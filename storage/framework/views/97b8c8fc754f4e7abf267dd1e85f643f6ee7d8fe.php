<?php $__env->startComponent('mail::message'); ?>
# Hello <?php echo e($mailData['names']); ?>,  

You've received a new **service request** from a customer. Below are the details:

---

## 🔹 **User Details**  
📛 **Name:** <?php echo e($mailData['names']); ?>  
📧 **Email:** [<?php echo e($mailData['email']); ?>](mailto:<?php echo e($mailData['email']); ?>)  
📞 **Phone:** [<?php echo e($mailData['phone']); ?>](tel:<?php echo e($mailData['phone']); ?>)  
📍 **Location:** <?php echo e($mailData['location']); ?>  

---

## 🛠 **Service Request**  
💼 **Requested Service:** <?php echo e($mailData['service_name']); ?>  
📅 **Date & Time:** <?php echo e($mailData['date']); ?> at <?php echo e($mailData['time']); ?>  
💳 **Payment Mode:** <?php echo e($mailData['payment_mode']); ?>  

<?php if(!empty($mailData['notes'])): ?>
📝 **Additional Notes:**  
_<?php echo e($mailData['notes']); ?>_
<?php endif; ?>

---

## ✅ **Next Steps**  
Click the button below to review and confirm the booking.

<?php $__env->startComponent('mail::button', ['url' => route('sprovider.dashboard')]); ?>
🔍 View Booking Details
<?php echo $__env->renderComponent(); ?>

If you have any questions, feel free to reach out.  

Thanks & Best Regards,  
**<?php echo e(config('app.name')); ?>**  

<?php echo $__env->renderComponent(); ?>
<?php /**PATH /home4/connector/public_html/hiletask/resources/views/emails/bookMail.blade.php ENDPATH**/ ?>