<div class="min-w-[480px] bg-white shadow rounded-md p-8">
    <h1 class="text-2xl text-gray-700 font-bold text-center mb-8">Choose Your Plan</h1>
    
    <div class="grid grid-cols-2 gap-6">
        <div class="border rounded-lg p-6 space-y-4 hover:shadow-lg transition-shadow">
            <h2 class="text-xl font-semibold">Basic Plan</h2>
            <p class="text-3xl font-bold">$29<span class="text-sm text-gray-500">/month</span></p>
            <ul class="space-y-2 text-gray-600">
                <li>✓ Basic Features</li>
                <li>✓ 24/7 Support</li>
                <li>✓ Monthly Updates</li>
            </ul>
            <form action="/subscription/create" method="POST">
                <input type="hidden" name="plan" value="basic">
                <button type="submit" class="w-full bg-gray-800 text-white rounded-md py-2 mt-4 hover:bg-gray-700">Subscribe Now</button>
            </form>
        </div>

        <div class="border rounded-lg p-6 space-y-4 hover:shadow-lg transition-shadow">
            <h2 class="text-xl font-semibold">Premium Plan</h2>
            <p class="text-3xl font-bold">$49<span class="text-sm text-gray-500">/month</span></p>
            <ul class="space-y-2 text-gray-600">
                <li>✓ All Basic Features</li>
                <li>✓ Premium Support</li>
                <li>✓ Advanced Features</li>
                <li>✓ Priority Updates</li>
            </ul>
            <form action="/subscription/create" method="POST">
                <input type="hidden" name="plan" value="premium">
                <button type="submit" class="w-full bg-gray-800 text-white rounded-md py-2 mt-4 hover:bg-gray-700">Subscribe Now</button>
            </form>
        </div>
    </div>
</div>