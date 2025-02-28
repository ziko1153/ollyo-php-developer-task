<div class="min-w-[480px] bg-white shadow rounded-md p-4 flex flex-col items-center gap-6">
    <div class="text-center space-y-2">
        <h1 class="text-2xl text-gray-700 font-bold">Subscription Activated!</h1>
        <p class="text-green-600">Your subscription has been successfully set up</p>
        <div class="text-sm text-gray-500">
            <p>Plan: <?php echo $subscription['plan_details']['name']; ?></p>
            <p>Agreement ID: <?php echo $subscription['agreement_id']; ?></p>
            <p>Status: <?php echo $subscription['status']; ?></p>
            <p>Start Date: <?php echo date('F j, Y', strtotime($subscription['start_date'])); ?></p>
            <p>Monthly Payment: $<?php echo $subscription['plan_details']['price']; ?></p>
        </div>
    </div>

    <div class="text-center space-y-4">
        <p class="text-gray-600">Thank you for subscribing!</p>
        <a href="/" class="inline-block hover:underline hover:underline-offset-4 hover:text-green-700">Return to Home</a>
    </div>
</div>