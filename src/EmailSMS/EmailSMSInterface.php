<?php

namespace Larablocks\EmailSMS;

/**
 * The EmailSMSHandler will require an object that implements this interface in order to send
 *
 * Interface EmailSMSInterface
 * @package Larablocks\EmailSMS
 */
interface EmailSMSInterface
{
    /**
     * Returns the domain of the phone service provider of the message receiver
     * @return string
     */
    public function getPhoneProvider();

    /**
     * Returns the ten digit phone number of the message receiver
     * @return integer
     */
    public function getPhoneNumber();

    /**
     * Returns the subject of the message. To skip the subject, return null.
     * @return mixed
     */
    public function getSubject();

    /**
     * Returns the body of the message
     * @return string
     */
    public function getBody();

    /**
     * Returns the email address of the sender
     * @return string
     */
    public function getSenderEmail();

    /**
     * Returns the name of the sender
     * @return string
     */
    public function getSenderName();

}