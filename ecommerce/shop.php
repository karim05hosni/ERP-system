<?php
$title = "shop";
require("layout/header.php");
require("layout/nav.php");
// include_once("layout/breadcrumb.php");
// include_once("layout/breadcrumb.php");
include_once "app/models/product.php";
include_once "app/models/brand.php";
$product = new product;
if (isset($_GET['sub'])) {
    $product->set_sub_cate_id($_GET['sub']);
    // echo "f";
}
$image_path = "../Admin_Panel/public/dist/img/products/";

$brands = new brand;
if (isset($_GET['brand'])) {
    $product->set_brand_id($_GET['brand']);
};
$read_product = $product->read();
$brands_arr = $brands->read()->fetch_all(MYSQLI_ASSOC);

// print_r($brands_arr[1]);
?>

<style>
    /* .shop-page-area{
        background-color:#eeeeee;
    } */
    .product-width {
        box-shadow: inset #DEEDEF;
    }

    .product-wrapper {
        /* position: relative; */
        border-radius: 6px;
        /* background-color: gray; */
        padding: 12px;
        box-shadow: 2px 3px #569b36;
    }
</style>

<body>
    <!-- Shop Page Area Start -->
    <div class="shop-page-area ptb-100">
        <div class="container">
            <div class="row flex-row-reverse">
                <div class="col-lg-9">
                    <div class="shop-topbar-wrapper">
                        <div class="shop-topbar-left">
                            <ul class="view-mode">
                                <li class="active"><a href="#product-grid" data-view="product-grid"><i class="fa fa-th"></i></a></li>
                                <li><a href="#product-list" data-view="product-list"><i class="fa fa-list-ul"></i></a></li>
                            </ul>
                            <p>Showing 1 - 20 of 30 results </p>
                        </div>
                        <div class="product-sorting-wrapper">
                            <div class="product-shorting shorting-style">
                                <label>View:</label>
                                <select>
                                    <option value=""> 20</option>
                                    <option value=""> 23</option>
                                    <option value=""> 30</option>
                                </select>
                            </div>
                            <div class="product-show shorting-style">
                                <label>Sort by:</label>
                                <select>
                                    <option value="">Default</option>
                                    <option value=""> Name</option>
                                    <option value=""> price</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (isset($_GET['s'])) {
                        echo '<div class="alert alert-success">Purchased Successfully !</div>';
                    }
                    ?>
                    <div class="grid-list-product-wrapper">
                        <div class="product-grid product-view pb-20">
                            <div class="row">
                                <?php
                                if (isset($read_product)) {
                                    if (!empty($read_product)) {
                                        $fetch_product = $read_product->fetch_all(MYSQLI_ASSOC);
                                        foreach ($fetch_product as $key => $value) {
                                ?>
                                            <div class="product-width col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-30">
                                                <div class="product-wrapper">
                                                    <div class="product-img">
                                                        <a href="product-details.php?pid=<?= $value['id'] ?>">
                                                            <img alt="" src="<?= $image_path . $value['image'] ?>">
                                                        </a>
                                                        <span>-30%</span>
                                                        <div class="product-action">
                                                            <a class="action-wishlist" href="#" title="Wishlist">
                                                                <i class="ion-android-favorite-outline"></i>
                                                            </a>
                                                            <!-- Add to Cart Button -->
                                                            <a class="action-cart add-to-cart" href="#" title="Add To Cart" data-product-id="<?= $value['id'] ?>" data-user-id="1" data-quantity="1">
                                                                <i class="ion-ios-shuffle-strong"></i>
                                                            </a>
                                                            <a class="action-compare" href="#" data-target="#exampleModal" data-toggle="modal" title="Quick View">
                                                                <i class="ion-ios-search-strong"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="product-content text-left">
                                                        <div class="product-hover-style">
                                                            <div class="product-title">
                                                                <h4>
                                                                    <a href="product-details.php?pid=<?= $value['id'] ?>"><?= $value['name_en'] ?></a>
                                                                </h4>
                                                            </div>
                                                            <div class="cart-hover add-to-cart" data-product-id="<?= $value['id'] ?>" data-user-id="1" data-quantity="1">
                                                                <h4><a href="#">+ Add to cart</a></h4>
                                                            </div>
                                                        </div>
                                                        <div class="product-price-wrapper">
                                                            <span><?= $value['price'] ?> EGP</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                <?php
                                        }
                                    } else {
                                        echo "<div class='alert alert-danger'> No products to show </div>";
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="pagination-total-pages">
                            <div class="pagination-style">
                                <ul>
                                    <li><a class="prev-next prev" href="#"><i class="ion-ios-arrow-left"></i> Prev</a></li>
                                    <li><a class="active" href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">...</a></li>
                                    <li><a href="#">10</a></li>
                                    <li><a class="prev-next next" href="#">Next<i class="ion-ios-arrow-right"></i> </a></li>
                                </ul>
                            </div>
                            <div class="total-pages">
                                <p>Showing 1 - 20 of 30 results </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="shop-sidebar-wrapper gray-bg-7 shop-sidebar-mrg">
                        <div class="shop-widget">
                            <h4 class="shop-sidebar-title">Shop By Categories</h4>
                            <div class="shop-catigory">
                                <ul id="faq">
                                    <!-- Categories start -->
                                    <?php
                                    if ($read_categories) {
                                        if ($fetched_categories) {
                                            foreach ($fetched_categories as $key => $category) {
                                                // retrieve
                                                $sub_category->setid($category['id']);
                                                $read_sub_categories = $sub_category->read();
                                                // fetch
                                                if (!empty($read_sub_categories->num_rows) && $read_sub_categories->num_rows > 0) {
                                    ?>
                                                    <li> <a data-toggle="collapse" data-parent="#faq" href="#shop-catigory-<?= $key ?>"><?= $category['name_en'] ?> <i class="ion-ios-arrow-down"></i></a>
                                                        <ul id="shop-catigory-<?= $key ?>" class="panel-collapse collapse show">
                                                            <?php
                                                            $fetch_sub_categories = $read_sub_categories->fetch_all(MYSQLI_ASSOC);
                                                            if (isset($fetch_sub_categories)) {
                                                                foreach ($fetch_sub_categories as $key => $value) {
                                                            ?>
                                                                    <!-- subcategories start -->
                                                                    <li><a href="shop.php?sub=<?= $value['id'] ?>"><?= $value['name_en'] ?></a></li>
                                                                    <!-- subcategories end -->
                                                                <?php } ?>
                                                        </ul>
                                                    </li>
                                            <?php
                                                            }
                                                        }
                                            ?>
                                            <!-- categories end -->
                                <?php
                                            }
                                        }
                                    }
                                ?>
                                </ul>
                            </div>
                        </div>
                        <div class="shop-widget mt-40 shop-sidebar-border pt-35">
                            <h4 class="shop-sidebar-title">By Brand</h4>
                            <div class="sidebar-list-style mt-20">
                                <ul>
                                    <?php
                                    foreach ($brands_arr as $key => $item) {
                                    ?>

                                        <ul class="panel-collapse collapse show">
                                            <li><a href="shop.php?brand=<?= $item['id'] ?>"><?= $item['name_en'] ?></a></li>
                                        </ul>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <div class="shop-widget mt-40 shop-sidebar-border pt-35">
                            <h4 class="shop-sidebar-title">Compare Products</h4>
                            <div class="compare-product">
                                <p>You have no item to compare. </p>
                                <div class="compare-product-btn">
                                    <span>Clear all </span>
                                    <a href="#">Compare <i class="fa fa-check"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Shop Page Area End -->
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <!-- Thumbnail Large Image start -->
                            <div class="tab-content">
                                <div id="pro-1" class="tab-pane fade show active">
                                    <img src="assets/img/product-details/product-detalis-l1.jpg" alt="">
                                </div>
                                <div id="pro-2" class="tab-pane fade">
                                    <img src="assets/img/product-details/product-detalis-l2.jpg" alt="">
                                </div>
                                <div id="pro-3" class="tab-pane fade">
                                    <img src="assets/img/product-details/product-detalis-l3.jpg" alt="">
                                </div>
                                <div id="pro-4" class="tab-pane fade">
                                    <img src="assets/img/product-details/product-detalis-l4.jpg" alt="">
                                </div>
                            </div>
                            <!-- Thumbnail Large Image End -->
                            <!-- Thumbnail Image End -->
                            <div class="product-thumbnail">
                                <div class="thumb-menu owl-carousel nav nav-style" role="tablist">
                                    <a class="active" data-toggle="tab" href="#pro-1"><img src="assets/img/product-details/product-detalis-s1.jpg" alt=""></a>
                                    <a data-toggle="tab" href="#pro-2"><img src="assets/img/product-details/product-detalis-s2.jpg" alt=""></a>
                                    <a data-toggle="tab" href="#pro-3"><img src="assets/img/product-details/product-detalis-s3.jpg" alt=""></a>
                                    <a data-toggle="tab" href="#pro-4"><img src="assets/img/product-details/product-detalis-s4.jpg" alt=""></a>
                                </div>
                            </div>
                            <!-- Thumbnail image end -->
                        </div>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <div class="modal-pro-content">
                                <h3>Dutchman's Breeches </h3>
                                <div class="product-price-wrapper">
                                    <span class="product-price-old">£162.00 </span>
                                    <span>£120.00</span>
                                </div>
                                <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet.</p>
                                <div class="quick-view-select">
                                    <div class="select-option-part">
                                        <label>Size*</label>
                                        <select class="select">
                                            <option value="">S</option>
                                            <option value="">M</option>
                                            <option value="">L</option>
                                        </select>
                                    </div>
                                    <div class="quickview-color-wrap">
                                        <label>Color*</label>
                                        <div class="quickview-color">
                                            <ul>
                                                <li class="blue">b</li>
                                                <li class="red">r</li>
                                                <li class="pink">p</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-quantity">
                                    <div class="cart-plus-minus">
                                        <input class="cart-plus-minus-box" type="text" name="qtybutton" value="02">
                                    </div>
                                    <button>Add to cart</button>
                                </div>
                                <span><i class="fa fa-check"></i> In stock</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->


    <?php
    include_once("layout/footer.php");
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent default link behavior

                    // Get product data from the button's data attributes
                    const productId = this.getAttribute('data-product-id');
                    const userId = this.getAttribute('data-user-id');
                    const quantity = this.getAttribute('data-quantity');

                    // Prepare the data to send
                    const data = {
                        user_id: <?=$_SESSION['user']->id ?>,
                        product_id: productId,
                        quantity: quantity
                    };
                    // Send AJAX POST request
                    fetch('app/post/add_to_cart.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(data)
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok.');
                            }
                            return response.json();
                        })
                        .then(result => {
                            if (result.success) {
                                alert('Product added to cart successfully!');
                                console.log('Cart ID:', result.cart_id);
                            } else {
                                alert('Failed to add product to cart: ' + result.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while adding the product to the cart.');
                        });
                    });
            });
        });
    </script>
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
</body>

</html>

<?php
