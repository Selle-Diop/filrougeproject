<?php

namespace App\Services;
use Twig\Environment;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
 

class  Mailservive {

    public function __construct (MailerInterface $mailer, Environment $twig) {
        $this->mailer = $mailer;
        $this->twig = $twig;


    }

    public function insertMail ($data,$subject="creation compte") {
        $from="mbayelo@gmail.com";
        $email= (new Email())
            ->from($from)
            ->to($data->getEmail())
            ->subject($subject)
            ->html($this->twig->render( "affiche/affiche.html.twig",[
                "token"=>$data->getToken(),
                "data"=>$data,
                // "subject"=>$subject
            ])
                
            );
            $this->mailer->send($email);
                                                  

    }

}
