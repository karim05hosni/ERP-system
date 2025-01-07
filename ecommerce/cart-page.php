<?php
$title = "cart";
include_once "layout/header.php";
include_once "layout/nav.php";
include_once "layout/breadcrumb.php";
include_once "app/middleware/auth.php";
include_once __DIR__ . "/app/models/cart.php";


$cart = new cart();
$cart_id = $cart->retrieveCardByUserId($_SESSION['user']->id)->fetch_array(MYSQLI_ASSOC)['id'];
$cart_items = $cart->readCart($cart_id);
// print_r($cart_items);die;
// die;
?>


<!doctype html>
<html class="no-js" lang="zxx">


<body>
    <!-- header start -->

    <!-- header end -->
    <!-- Breadcrumb Area Start -->

    <!-- shopping-cart-area start -->
    <div class="cart-main-area ptb-100">
        <div class="container">
            <h3 class="page-title">Your cart items</h3>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <form action="#">
                        <div class="table-content table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Unit Price</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cart_items['products'] as $product) { ?>
                                        <tr data-product-id="<?php echo $product['id']; ?>">
                                            <td class="product-thumbnail">
                                                <a href="#"><img src="assets/img/cart/cart-3.jpg" alt=""></a>
                                            </td>
                                            <td class="product-name"><a href="#"><?php echo $product['name_en']; ?></a></td>
                                            <td class="product-price-cart"><span class="amount">$<?php echo $product['price']; ?></span></td>
                                            <td class="product-quantity">
                                                <div class="pro-dec-cart">
                                                    <input class="cart-plus-minus-box" type="text" value="<?php echo $product['quantity']; ?>" name="qtybutton">
                                                </div>
                                            </td>
                                            <td class="product-subtotal">$<?php echo $product['price'] * $product['quantity']; ?></td>
                                            <td class="product-remove">
                                                <a href="#"><i class="fa fa-pencil"></i></a>
                                                <a href="#"><i class="fa fa-times"></i></a>
                                            </td>
                                            <td class="cart-plus-minus">
                                                <input class="cart-plus-minus-box" type="text" value="1">
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="cart-shiping-update-wrapper">
                                    <div class="cart-shiping-update">
                                        <a href="#">Continue Shopping</a>
                                    </div>
                                    <div class="cart-clear">
                                        <button>Update Shopping Cart</button>
                                        <a href="#">Clear Shopping Cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-lg-4 col-md-12">
                            <div class="grand-totall">
                                <div class="title-wrap">
                                    <h4 class="cart-bottom-title section-bg-gary-cart">Cart Total</h4>
                                </div>
                                <?php
                                // calculate the total amount of cart items
                                $total_amount = 0;
                                foreach ($cart_items['products'] as $product) {
                                    $total_amount += $product['price'] * $product['quantity'];
                                    }
                                ?>
                                <h5>Total products <span>$<?=$total_amount?></span></h5>
                                <div class="total-shipping">
                                    <h5>Total shipping</h5>
                                    <ul>
                                        <li><input type="checkbox"> Standard <span>$20.00</span></li>
                                        <li><input type="checkbox"> Express <span>$30.00</span></li>
                                    </ul>
                                </div>
                                <a href="#">Proceed to Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- shopping-cart-area end -->
    <!-- Footer style Start -->
    <footer class="footer-area pt-75 gray-bg-3">
        <div class="footer-top gray-bg-3 pb-35">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="footer-widget mb-40">
                            <div class="footer-title mb-25">
                                <h4>My Account</h4>
                            </div>
                            <div class="footer-content">
                                <ul>
                                    <li><a href="my-account.html">My Account</a></li>
                                    <li><a href="about-us.html">Order History</a></li>
                                    <li><a href="wishlist.html">WishList</a></li>
                                    <li><a href="#">Newsletter</a></li>
                                    <li><a href="about-us.html">Order History</a></li>
                                    <li><a href="#">International Orders</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="footer-widget mb-40">
                            <div class="footer-title mb-25">
                                <h4>Information</h4>
                            </div>
                            <div class="footer-content">
                                <ul>
                                    <li><a href="about-us.html">About Us</a></li>
                                    <li><a href="#">Delivery Information</a></li>
                                    <li><a href="#">Privacy Policy</a></li>
                                    <li><a href="#">Terms & Conditions</a></li>
                                    <li><a href="#">Customer Service</a></li>
                                    <li><a href="#">Return Policy</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="footer-widget footer-widget-red footer-black-color mb-40">
                            <div class="footer-title mb-25">
                                <h4>Contact Us</h4>
                            </div>
                            <div class="footer-about">
                                <p>Your current address goes to here,120 haka, angladesh</p>
                                <div class="footer-contact mt-20">
                                    <ul>
                                        <li>(+008) 254 254 254 25487</li>
                                        <li>(+009) 358 587 657 6985</li>
                                    </ul>
                                </div>
                                <div class="footer-contact mt-20">
                                    <ul>
                                        <li>yourmail@example.com</li>
                                        <li>example@admin.com</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom pb-25 pt-25 gray-bg-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="copyright">
                            <p><a target="_blank" href="https://www.templateshub.net">Templates Hub</a></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="payment-img f-right">
                            <a href="#">
                                <img alt="" src="assets/img/icon-img/payment.png">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer style End -->

    <!-- all js here -->
    <script src="assets/js/vendor/jquery-1.12.0.min.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="assets/js/isotope.pkgd.min.js"></script>
    <script src="assets/js/ajax-mail.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Handle click on the "Remove" icon
        document.querySelectorAll('.product-remove > a').forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent default link behavior

                // Get the product ID from the closest row
                const productId = this.closest('tr').dataset.productId;

                // Prepare the data to send
                const data = {
                    action: 'remove',
                    product_id: productId
                };

                // Send POST request to remove the item
                fetch('app/post/remove_from_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        alert('Product removed from cart successfully!');
                        location.reload(); // Reload the page to reflect changes
                    } else {
                        alert('Failed to remove product.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while removing the product.');
                });
            });
        });

        // document.addEventListener('DOMContentLoaded', function () {
    // Handle click on the "Update Cart" button
    document.querySelector('.cart-clear > button').addEventListener('click', function (event) {
        event.preventDefault(); // Prevent form submission

        // Collect updated quantities
        const updatedQuantities = {};
        const cartItems = document.querySelectorAll('tbody tr[data-product-id]'); // Select only cart item rows

        cartItems.forEach(row => {
            const productId = row.dataset.productId; // Get the product ID from the row
            const quantityInput = row.querySelector('.cart-plus-minus-box'); // Find the quantity input within the row
            const quantity = parseInt(quantityInput.value, 10); // Parse the quantity as an integer

            // Debugging: Log the product ID and quantity
            console.log("Product ID:", productId, "Quantity:", quantity);

            if (!isNaN(quantity) && quantity > 0) { // Ensure the quantity is valid
                updatedQuantities[productId] = quantity; // Use product_id as the key to avoid duplicates
            } else {
                console.error("Invalid quantity for product ID:", productId);
            }
        });

        // Convert the object to an array of { product_id, quantity } objects
        const quantitiesArray = Object.keys(updatedQuantities).map(productId => ({
            product_id: productId,
            quantity: updatedQuantities[productId]
        }));

        // Debugging: Log the updated quantities
        console.log("Updated quantities:", quantitiesArray);

        // Prepare the data to send
        const data = {
            action: 'update',
            quantities: quantitiesArray
        };

        // Send POST request to update the cart
        fetch('app/post/remove_from_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert('Cart updated successfully!');
                location.reload(); // Reload the page to reflect changes
            } else {
                alert('Failed to update cart: ' + result.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the cart.');
        });
    });
});

</script>


</body>

</html>