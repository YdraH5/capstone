// Add event listeners to the check-in, check-out date inputs, and payment status dropdown
document.getElementById('checkin').addEventListener('change', validateDates);
document.getElementById('checkout').addEventListener('change', validateDates);
document.getElementById('pricePerMonth').addEventListener('input', calculateTotalPrice);
document.getElementById('paymentStatus').addEventListener('change', calculateTotalPrice);
document.getElementById('checkout').addEventListener('change', preventInvalidCheckOutDate);

function preventInvalidCheckOutDate() {
    const checkinDate = new Date(document.getElementById('checkin').value);
    const checkoutDate = new Date(document.getElementById('checkout').value);

    // Check if the check-out date is before the check-in date
    if (checkoutDate < checkinDate) {
        alert("Check-out date should be after check-in date.");
        document.getElementById('checkout').value = ''; // Clear invalid input
    }
}

function validateDates() {
    const today = new Date(); // Get today's date
    const checkinDate = new Date(document.getElementById('checkin').value);
    const checkoutDate = new Date(document.getElementById('checkout').value);

    // Compare selected check-in date with today's date
    if (checkinDate < today) {
        alert("Check-in date cannot be before the current date.");
        document.getElementById('checkin').value = ''; // Clear invalid input
    }

    // Compare selected check-out date with today's date
    if (checkoutDate < today) {
        alert("Check-out date cannot be before the current date.");
        document.getElementById('checkout').value = ''; // Clear invalid input
    }

    // Calculate total price if both dates are valid
    if (checkinDate <= checkoutDate) {
        calculateTotalPrice();
    }
}

function calculateTotalPrice() {
    const checkinDate = new Date(document.getElementById('checkin').value);
    const checkoutDate = new Date(document.getElementById('checkout').value);
    const pricePerMonth = parseFloat(document.getElementById('pricePerMonth').value);
    const paymentStatus = document.getElementById('paymentStatus').value;

    // Ensure price per month is valid and not empty
    if (!document.getElementById('pricePerMonth').value || isNaN(pricePerMonth) || pricePerMonth <= 0) {
        return;
    }

    // Calculate total number of months
    let diffMonths;
    if (checkoutDate >= checkinDate) {
        diffMonths = Math.ceil((checkoutDate - checkinDate) / (1000 * 60 * 60 * 24 * 30));
    } else {
        alert("Check-out date should be after check-in date.");
        return;
    }

    // Calculate total price based on payment status
    let totalPrice;
    if (paymentStatus === 'Balance') {
        // Calculate 20% downpayment
        totalPrice = +(pricePerMonth * 0.2).toFixed(2);
    } else {
        // Calculate full payment
        totalPrice = +(pricePerMonth * diffMonths).toFixed(2);
    }

    // Display total price
    document.getElementById('totalPrice').value = totalPrice;

    // Calculate and display balance
    const balance = ( (pricePerMonth * diffMonths)-totalPrice ).toFixed(2);
    document.getElementById('balanceMessage').textContent = `You'll have a Balance of: ₱${balance}`;

    // Ensure minimum reservation period of 1 month
    if (diffMonths < 1) {
        document.getElementById('chargeMessage').textContent = "You will be charged for 1 month.";
    } else {
        document.getElementById('chargeMessage').textContent = "";
    }
}
 