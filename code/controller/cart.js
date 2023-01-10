if (document.readyState === 'loading'){
    document.addEventListener('DOMContentLoaded',ready);
} else {
    ready();
}

var inCart = [];

function ready() {
    var removeCartItemButtons = document.getElementsByClassName('btn-danger');
    for (var i = 0; i < removeCartItemButtons.length; i++) {
        var removeButton = removeCartItemButtons[i];
        removeButton.addEventListener('click', removeCartItem);
    }

    var quantityInputs = document.getElementsByClassName('item-quantity');
    for (var j = 0; j < quantityInputs.length; j++){
        var input = quantityInputs[j];
        input.addEventListener('change', quantityChange);
    }

    var addToCartL = document.getElementsByClassName('shop-add-button-l');
    for (var k = 0; k < addToCartL.length; k++){
        var buttonL = addToCartL[k];
        buttonL.addEventListener('click',addtoCartClickedL);
    }

    var addToCartP = document.getElementsByClassName('shop-add-button-p');
    for (var l = 0; l < addToCartP.length; l++){
        var buttonP = addToCartP[l];
        buttonP.addEventListener('click',addtoCartClickedP);
    }

    $('.btn-lg').click(function (){
        let poleHodnot = [];
        for (var a = 0; a < sluzby.length; a++){
            for (var b = 0; b < inCart.length; b++){
                if (sluzby[a][1] === inCart[b].id){
                    poleHodnot[inCart[b].id] = inCart[b].value;
                }
            }
        }
        for (var c = 0; c < prislusenstvi.length; c++){
            for (var d = 0; d < inCart.length; d++){
                if (prislusenstvi[c][1] === inCart[d].id){
                    poleHodnot[inCart[d].id] = inCart[d].value;
                }
            }
        }
        console.log(poleHodnot);

        $.ajax({
            method: 'POST',
            url: 'index.php?page=objednavka',
            data: {poleHodnot: poleHodnot},
        })
        //register();
    })
}

function register(){
   // alert('Thank you!');
    var cartItems = document.getElementsByClassName('list-group')[0];
    while (cartItems.hasChildNodes()){
        cartItems.removeChild(cartItems.firstChild);
    }
    updateCartTotalPrice();
}

function removeCartItem(event) {
    var buttonClicked = event.target;
    buttonClicked.parentElement.remove();
    updateCartTotalPrice();
}

function quantityChange(event){
    var input = event.target;
    if (isNaN(input.value) || input.value <= 0){
        input.value = 1;
    }
    updateCartTotalPrice();
}

function addtoCartClickedL(event) {
    var button = event.target;
    var shopItem = button.parentElement;
    var title = shopItem.getElementsByClassName('cart-item-name-l')[0].innerText;
    var price = shopItem.getElementsByClassName('cart-item-price-l')[0].innerText;
    addItemToCartL(title,price);
    updateCartTotalPrice();
}

function addtoCartClickedP(event) {
    var button = event.target;
    var shopItem = button.parentElement;
    var title = shopItem.getElementsByClassName('cart-item-name-p')[0].innerText;
    var price = shopItem.getElementsByClassName('cart-item-price-p')[0].innerText;
    addItemToCartL(title,price)
    updateCartTotalPrice();
}

function addItemToCartL(title,price){
    var cartRow = document.createElement('div');
    var cartItems = document.getElementsByClassName('list-group')[0];
    var cartItemNames = cartItems.getElementsByClassName('my-0');
    for (var i = 0; i <cartItemNames.length; i++){
        if (cartItemNames[i].innerText === title){
            Swal.fire({
                icon: 'error',
                title: 'Položku "' + title + '" už ve vozíku máte!',
                text: "Pokud chcete zvýšit počet, můžete tak učinit ve vozíku.",
                showConfirmButton: true,
                allowOutsideClick: false,
                confirmButtonText: `OK`,
            });
            return;
        }
    }
    novejTitle = title.replace(/\s/g, 'XXXX');

    var cartRowContents = `<li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">${title}</h6>
                        <small class="price-cart text-muted">${price}</small>
                    </div>
                    <input type="number" name="${novejTitle}" id="${novejTitle}" class="item-quantity form-control col-md-3" min="1" value="1">
                    <button class="btn btn-danger" type="button">Odstraň</button>
                </li>`;
    cartRow.innerHTML = cartRowContents;
    cartItems.append(cartRow);
    cartRow.getElementsByClassName('btn-danger')[0].addEventListener('click',removeCartItem);
    cartRow.getElementsByClassName('item-quantity')[0].addEventListener('change', quantityChange);
    inCart = document.querySelectorAll('input[type=number]');

}


function updateCartTotalPrice() {
    var cartItem = document.getElementsByClassName('list-group')[0];
    var cartRows = cartItem.getElementsByClassName('list-group-item');
    var totalPrice = 0;
    for (var i = 0; i < cartRows.length; i++) {
        var cartRow = cartRows[i];
        var priceElement = cartRow.getElementsByClassName('price-cart')[0];
        var quantityElement = cartRow.getElementsByClassName('item-quantity')[0];
        if (priceElement) {
        var price = parseFloat(priceElement.innerText.replace(' KČ',''));
        var quantity = quantityElement.value;
        totalPrice += (price * quantity);
        }
    }
    var itemsInCart = document.getElementsByClassName('badge-pill')[0];
    itemsInCart.innerText = cartRows.length;
    totalPrice = Math.round(totalPrice * 100) / 100;
    document.getElementsByClassName('cart-total')[0].innerText = totalPrice + " KČ";
}