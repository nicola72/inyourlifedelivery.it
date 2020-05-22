<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Model\Order;
use App\Model\Shop;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Order
     */
    protected $order;

    /**
     * @var Shop
     */
    protected $shop;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, Shop $shop)
    {
        $this->order = $order;
        $this->shop = $shop;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $params = [
            'order' => $this->order,
            'shop'=> $this->shop,
        ];
        return $this->from($this->shop->email)
            ->subject('Nuova ordinazione '.$this->shop->insegna )
            ->view('website.email.order',$params);
    }
}