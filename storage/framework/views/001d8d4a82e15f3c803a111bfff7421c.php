<?php $__env->startComponent('mail::message'); ?>
# Payment Received ✅

Hello <?php echo new \Illuminate\Support\EncodedHtmlString($order->customer_name ?? $order->name ?? 'Customer'); ?>,

We have received your payment for order **<?php echo new \Illuminate\Support\EncodedHtmlString($order->order_number ?? $order->id); ?>**.

**Amount:** <?php echo new \Illuminate\Support\EncodedHtmlString(number_format($order->total, 2)); ?> $

<?php if(!empty($order->items)): ?>
**Items**
<?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
- <?php echo new \Illuminate\Support\EncodedHtmlString($it->name); ?> × <?php echo new \Illuminate\Support\EncodedHtmlString($it->qty); ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

Thanks for shopping with <?php echo new \Illuminate\Support\EncodedHtmlString(config('app.name')); ?>.

Regards,  
<?php echo new \Illuminate\Support\EncodedHtmlString(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\wamp64\www\E-commerce\c2c-shop - Copy\resources\views/emails/payment_success.blade.php ENDPATH**/ ?>