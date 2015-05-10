<?php

class EmailSMSHandlerTest extends TestCase
{
    private $stub;
    private $phoneProvider = 'vtext.com';
    private $phoneNumber = 5555555555;
    private $subject = 'subject';
    private $body = 'body';
    private $senderEmail = 'foo@bar.com';
    private $senderName = 'Sender Name';
    
    public function testSendTrue()
    {
        $this->createStub();
        $this->buildSuccessfulStub();
        $emailSMSHandler = new Larablocks\EmailSMS\EmailSMSHandler();
        $this->assertTrue($emailSMSHandler->send($this->stub));
    }
    
    public function testValidatePhoneProviderFailNotString() 
    {
        $this->createStub();
        
        $this->stub->method('getPhoneProvider')->willReturn(555);
        
        $this->buildSuccessfulStub();
        
        $emailSMSHandler = new Larablocks\EmailSMS\EmailSMSHandler();
        $this->assertFalse($emailSMSHandler->send($this->stub));
    }
    
    public function testValidatePhoneProviderFailNotInArray() 
    {
        $this->createStub();
        
        $this->stub->method('getPhoneProvider')->willReturn('foo.com');
        
        $this->buildSuccessfulStub();
        
        $emailSMSHandler = new Larablocks\EmailSMS\EmailSMSHandler();
        $this->assertFalse($emailSMSHandler->send($this->stub));
    }

    public function testValidatePhoneNumberFailNotNumeric() 
    {
        $this->createStub();
        
        $this->stub->method('getPhoneNumber')->willReturn('not a number');
        
        $this->buildSuccessfulStub();
        
        $emailSMSHandler = new Larablocks\EmailSMS\EmailSMSHandler();
        $this->assertFalse($emailSMSHandler->send($this->stub));
    }

    public function testValidatePhoneNumberFailNot10Digits() 
    {
        $this->createStub();
        
        $this->stub->method('getPhoneNumber')->willReturn(55555555555);
        
        $this->buildSuccessfulStub();
        
        $emailSMSHandler = new Larablocks\EmailSMS\EmailSMSHandler();
        $this->assertFalse($emailSMSHandler->send($this->stub));
    }

    public function testValidateSubjectFailNotString() 
    {
        $this->createStub();
        
        $this->stub->method('getSubject')->willReturn(1);
        
        $this->buildSuccessfulStub();
        
        $emailSMSHandler = new Larablocks\EmailSMS\EmailSMSHandler();
        $this->assertFalse($emailSMSHandler->send($this->stub));
    }

    public function testValidateBodyFailNotString() 
    {
        $this->createStub();
        
        $this->stub->method('getBody')->willReturn(1);
        
        $this->buildSuccessfulStub();
        
        $emailSMSHandler = new Larablocks\EmailSMS\EmailSMSHandler();
        $this->assertFalse($emailSMSHandler->send($this->stub));
    }

    public function testValidateSenderEmailFailNotString() 
    {
        $this->createStub();
        
        $this->stub->method('getSenderEmail')->willReturn(1);
        
        $this->buildSuccessfulStub();
        
        $emailSMSHandler = new Larablocks\EmailSMS\EmailSMSHandler();
        $this->assertFalse($emailSMSHandler->send($this->stub));
    }

    public function testValidateSenderEmailFailNotValidEmail() 
    {
        $this->createStub();
        
        $this->stub->method('getSenderEmail')->willReturn('notvalidemail@gmail.');
        
        $this->buildSuccessfulStub();
        
        $emailSMSHandler = new Larablocks\EmailSMS\EmailSMSHandler();
        $this->assertFalse($emailSMSHandler->send($this->stub));
    }

    public function testValidateSenderNameFailNotString() 
    {
        $this->createStub();
        
        $this->stub->method('getSenderEmail')->willReturn(1);
        
        $this->buildSuccessfulStub();
        
        $emailSMSHandler = new Larablocks\EmailSMS\EmailSMSHandler();
        $this->assertFalse($emailSMSHandler->send($this->stub));
    }
    
    private function createStub()
    {
        $this->stub = $this->getMock('\Larablocks\EmailSMS\EmailSMSInterface');
    }
    
    private function buildSuccessfulStub()
    {
        // Configure the stub.
        $this->stub->method('getPhoneProvider')->willReturn($this->phoneProvider);
        $this->stub->method('getPhoneNumber')->willReturn($this->phoneNumber);
        $this->stub->method('getSubject')->willReturn($this->subject);
        $this->stub->method('getBody')->willReturn($this->body);
        $this->stub->method('getSenderEmail')->willReturn($this->senderEmail);
        $this->stub->method('getSenderName')->willReturn($this->senderName);
    }
}