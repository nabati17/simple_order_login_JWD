<?php

class Cart
{
    private $cart;
    private $total;

    public function __construct(&$session)
    {
        $this->cart = &$session['cart'];
        $this->total = &$session['total'];
    }

    public function addToCart($menu, $price)
{
    $cartIndex = $this->findItemIndex($menu);
    if ($cartIndex !== null) {
        // Jika item pesanan sudah ada dalam keranjang, hapus item dari keranjang dan kurangi total harga
        $this->total -= $this->cart[$cartIndex]['harga'];
        unset($this->cart[$cartIndex]);
    } else {
        // Jika item pesanan belum ada dalam keranjang, tambahkan item ke keranjang dan tambahkan total harga
        $this->cart[] = [
            'menu' => $menu,
            'harga' => $price
        ];
        $this->total += $price;
    }
}

    public function clearCart()
    {
        $this->cart = [];
        $this->total = 0;
    }

    public function getCart()
    {
        return $this->cart;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function isInCart($menu)
    {
        return $this->findItemIndex($menu) !== null;
    }

    private function findItemIndex($menu)
    {
        if (!empty($this->cart)) {
            foreach ($this->cart as $index => $item) {
                if ($item['menu'] === $menu) {
                    return $index;
                }
            }
        }
        return null;
    }

    public function getSessionData()
    {
        return [
            'cart' => $this->cart,
            'total' => $this->total
        ];
    }
}