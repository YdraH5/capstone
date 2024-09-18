function calculateTotalPrice() {
    const pricePerMonth = parseFloat(document.getElementById('pricePerMonth').value);
    const paymentStatus = document.getElementById('paymentStatus').value;

    // Ensure price per month is valid and not empty
    if (!document.getElementById('pricePerMonth').value || isNaN(pricePerMonth) || pricePerMonth <= 0) {
        return;
    }

    let totalPrice;
    let totalBalance;
    if (paymentStatus === 'Paid') {
        // Calculate the reservation fee as 20% of the price per month
        const reservationFee = +(pricePerMonth * 0.2).toFixed(2);
        totalPrice = reservationFee;

        // Set total balance (if needed) to the reservation fee
        totalBalance = totalPrice;
    }

    // Display the reservation fee (total price)
    document.getElementById('totalPrice').value = totalPrice;

    // Display total balance (if applicable)
    document.getElementById('totalBalanceInput').value = totalBalance;

    // Display reservation fee message
    document.getElementById('balanceMessage').textContent = `Reservation fee is 20% of the monthly rent.`;

    // Ensure there are no additional charges based on months anymore
    document.getElementById('chargeMessage').textContent = "";
}
