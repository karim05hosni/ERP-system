<?php
include_once __DIR__ . "\..\database\config.php";
include_once __DIR__ . "\..\database\ops.php";


class cart extends config implements ops
{
    private $product_id;
    private $user_id;
    private $quantity;

    // Setters
    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    // Getters
    public function getProductId()
    {
        return $this->product_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    // ---- END SETTERS & GETTERS ------

    public function creat()
    {
        // Insert into carts table
        $query = "INSERT INTO carts (user_id, created_at, updated_at) VALUES ($this->user_id, NOW(), NOW())";
        $result = $this->runDML($query);
        if ($result){
            $cart_id = $this->con->insert_id;
            return $cart_id;
        } else {
            return false;
        }
        // if ($result) {
        //     // Get the last inserted cart ID

        //     // Insert into cart_product table
        //     $query = "INSERT INTO cart_product (cart_id, product_id, quantity) VALUES ($cart_id, $this->product_id, $this->quantity)";
        //     $result = $this->runDML($query);

        //     return $cart_id;
        // } else {
        //     return false;
        // }
    }
    public function insertProducts($cart_id, $product_id, $quantity)
    {
        // Check if the product already exists in the cart
        $query = "SELECT * FROM cart_product WHERE cart_id = $cart_id AND product_id = $product_id";
        $result = $this->runDQL($query);

        if ($result && $result->num_rows > 0) {
            // Product exists, update the quantity
            $existing_quantity = $result->fetch_assoc()['quantity'];
            $new_quantity = $existing_quantity + $quantity;

            $query = "UPDATE cart_product SET quantity = $new_quantity WHERE cart_id = $cart_id AND product_id = $product_id";
            return $this->runDML($query);
        } else {
            // Product does not exist, insert a new record
            $query = "INSERT INTO cart_product (cart_id, product_id, quantity) VALUES ($cart_id, $product_id, $quantity)";
            return $this->runDML($query);
        }
    }
    public function __call($method, $arguments)
    {
        if ($method == 'read') {
            if (count($arguments) == 1) {
                return $this->readCart($arguments[0]);
            } elseif (count($arguments) == 0) {
                return $this->readAllCarts();
            } else {
                throw new Exception("Invalid number of arguments for method '$method'");
            }
        } else {
            throw new Exception("Method '$method' does not exist");
        }
        if ($method == 'update') {
            if (count($arguments) == 3) {
                return $this->updateCart($arguments[0], $arguments[1], $arguments[2]);
            } elseif (count($arguments) == 0) {
                return $this->update();
            } else {
                throw new Exception("Invalid number of arguments for method '$method'");
            }
        } else {
            throw new Exception("Method '$method' does not exist");
        }
    }

    private function readAllCarts()
    {
        // Fetch all cart details
        $query = "SELECT * FROM carts";
        $cart_result = $this->runDQL($query);

        if ($cart_result && $cart_result->num_rows > 0) {
            $carts = $cart_result->fetch_all(MYSQLI_ASSOC);

            // Fetch associated products for each cart
            foreach ($carts as &$cart) {
                $query = "SELECT p.*, cp.quantity FROM products p 
                          JOIN cart_product cp ON p.id = cp.product_id 
                          WHERE cp.cart_id = $cart[id]";
                $products_result = $this->runDQL($query);

                if ($products_result && $products_result->num_rows > 0) {
                    $cart['products'] = $products_result->fetch_all(MYSQLI_ASSOC);
                } else {
                    $cart['products'] = [];
                }
            }

            return $carts;
        } else {
            return [];
        }
    }
    public function read() {}
    public function retrieveCardByUserId($user_id)
    {
        $query = "SELECT * FROM carts WHERE user_id = $user_id";
        $result = $this->runDQL($query);
        return $result;
    }
    public function readCart($cart_id)
    {
        // Fetch cart details
        $query = "SELECT * FROM carts WHERE id = $cart_id";
        $cart_result = $this->runDQL($query);

        if ($cart_result && $cart_result->num_rows > 0) {
            $cart = $cart_result->fetch_assoc();

            // Fetch associated products
            $query = "SELECT p.id, p.name_en, p.price,  cp.quantity FROM products p 
            JOIN cart_product cp ON p.id = cp.product_id 
            WHERE cp.cart_id = $cart_id";
            $products_result = $this->runDQL($query);

            if ($products_result && $products_result->num_rows > 0) {
                $cart['products'] = $products_result->fetch_all(MYSQLI_ASSOC);
            } else {
                $cart['products'] = [];
            }

            return $cart;
        } else {
            return [];
        }
    }
    public function update() {}
    public function updateCart($cart_id, $product_id, $new_quantity)
    {
        // Update the quantity in the cart_product table
        $query = "UPDATE cart_product SET quantity = $new_quantity WHERE cart_id = $cart_id AND product_id = $product_id";
        $result = $this->runDML($query);

        if ($result) {
            // Update the updated_at field in the carts table
            $query = "UPDATE carts SET updated_at = NOW() WHERE id = $cart_id";
            $this->runDML($query);
            return true;
        } else {
            return false;
        }
    }
    public function delete() {}
    public function removeItem($product_id){
        // Remove the product from the cart_product table
        $query = "DELETE FROM cart_product WHERE product_id = $product_id";
        $result = $this->runDML($query);
    }
    public function updateQuantity($product_id, $quantity){
        // Update the quantity in the cart_product table
        $query = "UPDATE cart_product SET quantity = $quantity WHERE product_id = $product_id";
        $result = $this->runDML($query);
    }
}
