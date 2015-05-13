<?php namespace Larablocks\EmailSMS;

use Illuminate\Mail\Mailer;
use Illuminate\Log\Writer;

class EmailSMSHandler
{
    private $mailer;
    private $log;
    private $emailSMS;
    private $validPhoneProviders;

    public function __construct(Mailer $mailer, Writer $log)
    {
        $this->mailer = $mailer;
        $this->log = $log;
        $this->buildValidPhoneProviders();
    }

    /**
     * Send an sms via email through a validated provider.
     * Any class that implements the EmailSMS Interface can be passed to this method
     *
     * @param EmailSMSInterface $emailSMS
     * @return bool
     */
    public function send(EmailSMSInterface $emailSMS)
    {
        $this->emailSMS = $emailSMS;

        if (!$this->validateMessage()) {
            return false;
        }

        $this->mailer->raw($emailSMS->getBody(), function($message) use($emailSMS)
        {
            $receiverEmail = $emailSMS->getPhoneNumber() . '@' . $emailSMS->getPhoneProvider();

            if(!is_null($emailSMS->getSubject())) {
                $message->subject($emailSMS->getSubject());
            }

            $message->from($emailSMS->getSenderEmail(), $emailSMS->getSenderName());
            $message->to($receiverEmail);
        });

        return true;
    }

    /**
     * Validate the message object
     *
     * @return bool
     */
    private function validateMessage()
    {
        if (!$this->validatePhoneProvider()) {
            return false;
        }

        if (!$this->validatePhoneNumber()) {
            return false;
        }

        if (!$this->validateSubject()) {
            return false;
        }

        if (!$this->validateBody()) {
            return false;
        }

        if (!$this->validateSenderEmail()) {
            return false;
        }

        if (!$this->validateSenderName()) {
            return false;
        }

        return true;
    }


    /**
     * Validate the phone service provider (Verizon, Virgin Mobile, etc)
     *
     * @return bool
     */
    private function validatePhoneProvider()
    {
        $phoneProvider = $this->emailSMS->getPhoneProvider();

        if (!is_string($phoneProvider)) {
            $this->log->error('Phone provider must be a string');
            return false;
        }

        if (!in_array($phoneProvider,$this->validPhoneProviders)){
            $this->log->error('Phone provider not found');
            return false;
        }

        return true;
    }

    /**
     * Validate the phone number
     *
     * @return bool
     */
    private function validatePhoneNumber()
    {
        $phoneNumber = $this->emailSMS->getPhoneNumber();

        if (!is_numeric($phoneNumber)) {
            $this->log->error('Phone number must be of numeric type');
            return false;
        }

        $numberLength = strlen((string)$phoneNumber);

        if ($numberLength != 10) {
            $this->log->error('Phone number must be 10 digits in length');
            return false;
        }

        return true;
    }

    /**
     * Validate the text subject. Optional.
     *
     * @return bool
     */
    private function validateSubject()
    {
        $subject = $this->emailSMS->getSubject();

        if (!is_string($subject) && !is_null($subject)) {
            $this->log->error('Subject must be either a string or null');
            return false;
        }

        return true;
    }

    /**
     * Validate the body of the message
     *
     * @return bool
     */
    private function validateBody()
    {
        $body = $this->emailSMS->getBody();

        if (!is_string($body)) {
            $this->log->error('Message body must be a string');
            return false;
        }

        return true;
    }

    /**
     * Validate the sender's email
     *
     * @return bool
     */
    private function validateSenderEmail()
    {
        $senderEmail = $this->emailSMS->getSenderEmail();

        if (!is_string($senderEmail)) {
            $this->log->error('Sender email must be a string');
            return false;
        }

        if (filter_var($senderEmail, FILTER_VALIDATE_EMAIL) === false) {
            $this->log->error('Invalid sender email');
            return false;
        }

        return true;
    }

    /**
     * Validate the sender's name
     *
     * @return bool
     */
    private function validateSenderName()
    {
        $senderName = $this->emailSMS->getSenderName();

        if (!is_string($senderName)) {
            $this->log->error('Sender name must be a string');
            return false;
        }

        return true;
    }

    /**
     * Set the list of phone provider domains
     */
    private function buildValidPhoneProviders()
    {
        $this->validPhoneProviders = [
             '3 River Wireless' => 'sms.3rivers.net',
             'ACS Wireless' => 'paging.acswireless.com',
             'Alltel' => 'message.alltel.com',
             'AT&T' => 'txt.att.net',
             'Bell Canada' => 'txt.bellmobility.ca',
             'Bell Canada' => 'bellmobility.ca',
             'Bell Mobility (Canada)' => 'txt.bell.ca',
             'Bell Mobility' => 'txt.bellmobility.ca',
             'Blue Sky Frog' => 'blueskyfrog.com',
             'Bluegrass Cellular' => 'sms.bluecell.com',
             'Boost Mobile' => 'myboostmobile.com',
             'BPL Mobile' => 'bplmobile.com',
             'Carolina West Wireless' => 'cwwsms.com',
             'Cellular One' => 'mobile.celloneusa.com',
             'Cellular South' => 'csouth1.com',
             'Centennial Wireless' => 'cwemail.com',
             'CenturyTel' => 'messaging.centurytel.net',
             'Cingular (Now AT&T)' => 'txt.att.net',
             'Clearnet' => 'msg.clearnet.com',
             'Comcast' => 'comcastpcs.textmsg.com',
             'Corr Wireless Communications' => 'corrwireless.net',
             'Dobson' => 'mobile.dobson.net',
             'Edge Wireless' => 'sms.edgewireless.com',
             'Fido' => 'fido.ca',
             'Golden Telecom' => 'sms.goldentele.com',
             'Helio' => 'messaging.sprintpcs.com',
             'Houston Cellular' => 'text.houstoncellular.net',
             'Idea Cellular' => 'ideacellular.net',
             'Illinois Valley Cellular' => 'ivctext.com',
             'Inland Cellular Telephone' => 'inlandlink.com',
             'MCI' => 'pagemci.com',
             'Metrocall' => 'page.metrocall.com',
             'Metrocall 2-way' => 'my2way.com',
             'Metro PCS' => 'mymetropcs.com',
             'Microcell' => 'fido.ca',
             'Midwest Wireless' => 'clearlydigital.com',
             'Mobilcomm' => 'mobilecomm.net',
             'MTS' => 'text.mtsmobility.com',
             'Nextel' => 'messaging.nextel.com',
             'OnlineBeep' => 'onlinebeep.net',
             'PCS One' => 'pcsone.net',
             'President\'s Choice' => 'txt.bell.ca',
             'Public Service Cellular' => 'sms.pscel.com',
             'Qwest' => 'qwestmp.com',
             'Rogers AT&T Wireless' => 'pcs.rogers.com',
             'Rogers Canada' => 'pcs.rogers.com',
             'Satellink' => 'satellink.net',
             'Southwestern Bell' => 'email.swbw.com',
             'Sprint' => 'messaging.sprintpcs.com',
             'Sumcom' => 'tms.suncom.com',
             'Surewest Communicaitons' => 'mobile.surewest.com',
             'T-Mobile' => 'tmomail.net',
             'Telus' => 'msg.telus.com',
             'Tracfone' => 'txt.att.net',
             'Triton' => 'tms.suncom.com',
             'Unicel' => 'utext.com',
             'US Cellular' => 'email.uscc.net',
             'Solo Mobile' => 'txt.bell.ca',
             'Sprint' => 'messaging.sprintpcs.com',
             'Sumcom' => 'tms.suncom.com',
             'Surewest Communicaitons' => 'mobile.surewest.com',
             'T-Mobile' => 'tmomail.net',
             'Telus' => 'msg.telus.com',
             'Triton' => 'tms.suncom.com',
             'Unicel' => 'utext.com',
             'US Cellular' => 'email.uscc.net',
             'US West' => 'uswestdatamail.com',
             'Verizon' => 'vtext.com',
             'Virgin Mobile' => 'vmobl.com',
             'Virgin Mobile Canada' => 'vmobile.ca',
             'West Central Wireless' => 'sms.wcc.net',
             'Western Wireless' => 'cellularonewest.com'
        ];
    }

}