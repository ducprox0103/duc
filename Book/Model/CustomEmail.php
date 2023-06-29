<?php

namespace Hancocks\Book\Model;

use Magento\Framework\Mail\Template\TransportBuilder;

class CustomEmail
{
    protected $transportBuilder;

    public function __construct(
        TransportBuilder $transportBuilder
    ) {
        $this->transportBuilder = $transportBuilder;
    }

    public function sendCustomEmail($email, $name, $templateId, $templateVars)
    {
        $transport = $this->transportBuilder
            ->setTemplateIdentifier($templateId)
            ->setTemplateOptions([
                'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
            ])
            ->setTemplateVars($templateVars)
            ->setFrom([
                'email' => 'ducprox0103@gmail.com',
                'name' => 'Customer'
            ])
            ->addTo([$email => $name])
            ->getTransport();

        $transport->sendMessage();
    }
}
