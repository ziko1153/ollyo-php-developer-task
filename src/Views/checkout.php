<?php
$products = $data['products'];
$address = $data['address'];
$shippingCost = $data['shipping_cost'];

// @todo: Calculate the subtotal from the products array
$subtotal = 0;
?>

<form method="post" action="/checkout" class="space-y-8">
    <div class="grid grid-cols-[auto_350px] gap-8">
        <div class="space-y-4">
            <?php foreach ($products as $product) : ?>
                <div class="bg-white shadow p-4 flex gap-4 rounded-md">
                    <div class="w-[96px] h-[96px] relative rounded-md overflow-hidden">
                        <img src="<?php echo $product['image']; ?>"
                            class="absolute top-0 left-0 w-full h-full object-cover" />
                    </div>
                    <div class="space-y-2">
                        <h3 class="font-medium"><?php echo $product['name']; ?></h3>
                        <p class="text-sm text-gray-500"><?php echo '$' . $product['price']; ?></p>
                        <p class="text-sm text-gray-500">Qty: <?php echo $product['qty']; ?></p>
                    </div>

                    <?php $subtotal =  $subtotal + $product['price'] * $product['qty'];  ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="bg-white shadow p-4 rounded-md space-y-4 h-fit">
            <h4 class="text-lg font-semibold">Order Summary</h4>
            <div class="space-y-2">
                <div class="text-sm text-gray-500 flex items-center justify-between">
                    <p>Subtotal</p>
                    <p>$<?php echo $subtotal; ?></p>
                </div>
                <div class="text-sm text-gray-500 flex items-center justify-between">
                    <p>Shipping</p>
                    <p>$<?php echo $shippingCost; ?></p>
                </div>
            </div>
            <div class="w-full h-[1px] bg-gray-300"></div>
            <div class="font-semibold flex items-center justify-between">
                <p>Total</p>
                <p>$<?php echo $subtotal + $shippingCost; ?></p>
            </div>
            <button
                class="inline-flex w-full items-center justify-center gap-2 text-sm font-medium whitespace-nowrap rounded-md transition-colors ring-offset-2 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 bg-gray-800 text-white hover:bg-gray-700/90 h-9 px-4 py-2">Place
                Order</button>
        </div>
    </div>
    <div class="grid grid-cols-[auto_calc(350px_+2rem)]">
        <div>
            <h2 class="font-semibold text-xl">Shipping Information</h2>
            <div class="space-y-4 mt-4">
                <div class="space-y-1 flex flex-col">
                    <label class="text-sm text-gray-800 font-medium" for="name">Full Name</label>
                    <input type="text" name="name" placeholder="Enter your full name"
                        value="<?php echo $address['name']; ?>" id="name"
                        class="bg-white px-2 text-sm rounded-md border border-gray-300 h-10 placeholder:text-sm placeholder:text-gray-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-700 focus-visible:ring-offset-2">

                    <?php
                    if (isset($_SESSION['errors']['name'])): ?>
                        <div class="mb-2 text-sm text-red-800 dark:text-red-400" role="alert">
                            <span class="font-medium"><?= $_SESSION['errors']['name'] ?></span>
                        </div>
                    <?php endif ?>
                </div>
                <div class="space-y-1 flex flex-col">
                    <label class="text-sm text-gray-800 font-medium" for="name">Email</label>
                    <input type="email" name="email" placeholder="Enter your email"
                        value="<?php echo $address['email']; ?>" id="email"
                        class="bg-white px-2 text-sm rounded-md border border-gray-300 h-10 placeholder:text-sm placeholder:text-gray-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-700 focus-visible:ring-offset-2">

                    <?php if (isset($_SESSION['errors']['email'])): ?>
                        <div class="mb-2 text-sm text-red-800 dark:text-red-400" role="alert">
                            <span class="font-medium"><?= $_SESSION['errors']['email'] ?></span>
                        </div>
                    <?php endif ?>
                </div>
                <div class="space-y-1 flex flex-col">
                    <label class="text-sm text-gray-800 font-medium" for="address">Address</label>
                    <input type="text" name="address" placeholder="Enter your address" id="address"
                        value="<?php echo $address['address']; ?>"
                        class="bg-white px-2 text-sm rounded-md border border-gray-300 h-10 placeholder:text-sm placeholder:text-gray-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-700 focus-visible:ring-offset-2">
                    <?php if (isset($_SESSION['errors']['address'])): ?>
                        <div class="mb-2 text-sm text-red-800 dark:text-red-400" role="alert">
                            <span class="font-medium"><?= $_SESSION['errors']['address'] ?></span>
                        </div>
                    <?php endif ?>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1 flex flex-col">
                        <label class="text-sm text-gray-800 font-medium" for="city">City</label>
                        <input type="text" name="city" placeholder="Enter your city" id="city"
                            value="<?php echo $address['city']; ?>"
                            class="bg-white px-2 text-sm rounded-md border border-gray-300 h-10 placeholder:text-sm placeholder:text-gray-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-700 focus-visible:ring-offset-2">
                        <?php if (isset($_SESSION['errors']['city'])): ?>
                            <div class="mb-2 text-sm text-red-800 dark:text-red-400" role="alert">
                                <span class="font-medium"><?= $_SESSION['errors']['city'] ?></span>
                            </div>
                        <?php endif ?>
                    </div>
                    <div class="space-y-1 flex flex-col">
                        <label class="text-sm text-gray-800 font-medium" for="postal-code">Postal Code</label>
                        <input type="text" name="post_code" placeholder="Enter postal code" id="postal-code"
                            value="<?php echo $address['post_code']; ?>"
                            class="bg-white px-2 text-sm rounded-md border border-gray-300 h-10 placeholder:text-sm placeholder:text-gray-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-700 focus-visible:ring-offset-2">
                        <?php if (isset($_SESSION['errors']['post_code'])): ?>
                            <div class="mb-2 text-sm text-red-800 dark:text-red-400" role="alert">
                                <span class="font-medium"><?= $_SESSION['errors']['post_code'] ?></span>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>