<?php

// app/Http/Livewire/cart.php

namespace App\Http\Livewire;

use Livewire\Component;

class cart extends Component
{
    public $cart = [];

    public function mount()
    {
        $this->cart = session()->get('cart', []);
    }

    public function increment($id)
    {
        if (isset($this->cart[$id])) {
            $this->cart[$id]['quantity']++;
        }
        session()->put('cart', $this->cart);
    }

    public function decrement($id)
    {
        if (isset($this->cart[$id]) && $this->cart[$id]['quantity'] > 1) {
            $this->cart[$id]['quantity']--;
        }
        session()->put('cart', $this->cart);
    }

    public function remove($id)
    {
        unset($this->cart[$id]);
        session()->put('cart', $this->cart);
    }

    public function clear()
    {
        $this->cart = [];
        session()->forget('cart');
    }

    public function getTotalProperty()
    {
        return collect($this->cart)->sum(fn($item) => $item['price'] * $item['quantity']);
    }

    public function render()
    {
        return view('livewire.cart');
    }
}

