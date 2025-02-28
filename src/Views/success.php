<div class="min-w-[480px] bg-white shadow rounded-md p-4 flex flex-col items-center gap-6">
    <div class="text-center space-y-2">
        <h1 class="text-2xl text-gray-700 font-bold">Payment Successful!</h1>
        <p class="text-green-600">Your order has been confirmed</p>
        <div class="text-sm text-gray-500">
            <p>Order Date: <?php echo date('F j, Y g:i A', strtotime($order['date'])); ?></p>
            <p>Invoice Number: <?php echo $order['invoice_number']; ?></p>
            <p>Payment ID: <?php echo $order['payment_id']; ?></p>
        </div>
    </div>

    <div class="w-full space-y-4">
        <h2 class="text-lg font-semibold border-b pb-2">Order Summary</h2>
        <?php foreach ($order['products'] as $product) : ?>
            <div class="flex justify-between items-center">
                <div class="flex gap-2">
                    <span class="text-gray-600"><?php echo $product['qty']; ?>x</span>
                    <span><?php echo $product['name']; ?></span>
                </div>
                <span class="text-gray-600">$<?php echo number_format($product['price'] * $product['qty'], 2); ?></span>
            </div>
        <?php endforeach; ?>
        
        <div class="border-t pt-2 space-y-2">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Subtotal</span>
                <span>$<?php echo number_format($order['subtotal'], 2); ?></span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Shipping</span>
                <span>$<?php echo number_format($order['shipping'], 2); ?></span>
            </div>
            <div class="flex justify-between font-semibold">
                <span>Total</span>
                <span>$<?php echo number_format($order['total'], 2); ?></span>
            </div>
        </div>
    </div>

    <div class="text-center space-y-4">
        <p class="text-gray-600"><?php echo $message; ?></p>
        <a href="/" class="inline-block hover:underline hover:underline-offset-4 hover:text-green-700">Return to Home</a>
    </div>
</div>