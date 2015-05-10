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
    public function getPhoneProvider();
    public function getPhoneNumber();
    public function getSubject();
    public function getBody();
    public function getSenderEmail();
    public function getSenderName();

}