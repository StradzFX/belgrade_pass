jQuery( document ).ready( function() {
    if (jQuery('body').hasClass('taxonomy-product_cat')) {
        var name = document.getElementById("name");
        if (name.value == "GiftCoupon"){
            document.getElementById("name").disabled = true;
        }
    }
});