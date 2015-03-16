/**
 * This file is responsible for handling all user interactions with his or her
 * inventory. 
 */

$(document).ready(function() {

    /**
     * Redirects to the homepage
     */
    $('#redirect').click(function() {
        var url = 'http://web.engr.oregonstate.edu/~iannie/final/';
        $(location).attr('href', url);
    });

    /**
     * Logs current user out and updates status
     * and then redirects to homepage
     */
    $('#logout').click(function() {
        $.post('logout.php', function(data) {
            $('#pageStatus').empty();
            $('#pageStatus').append(data);
            $('#pageStatus').append('<br />Redirecting...');
            var url = 'http://web.engr.oregonstate.edu/~iannie/final/';
            $(location).attr('href', url);
        });
        
    });

    /**
     * Sends a request to the inventorySystem to add
     * inputted item. Displays any success/error messages
     * for the user to see and resets the form if successful.
     */
    $('#submitAdd').click(function() {
        $.post('inventorySystem.php', {
            add: 1, //signals inventorySystem to what action to take
            product: $('#product').val(),
            cost: $('#cost').val(),
            quantity: $('#quantity').val()
        }, function(data) {
            $('#addedStatus').empty();
            $('#addedStatus').append(data);
            if (data == 'Successfully Added') {
                $("#addForm")[0].reset();
                loadProducts();
            }
        });
    });

    /**
     * On blur checks if the product already exists in the
     * user's inventory and displays status.
     */
    $('#product').blur(function() {
        $('#productStatus').empty();
        if ($('#product').val() != '') {
            $.post('inventorySystem.php', {
                checkProduct: $('#product').val()   //signals inventorySystem to what action to take
            }, function(data) {
                $('#productStatus').empty();
                $('#productStatus').append(data);
            });
        }
    });

    /**
     * On blur checks to make sure the entered cost is the proper
     * format and displays the returned message.
     */
    $('#cost').blur(function() {
        $('#costStatus').empty();
        if ($('#cost').val() != '') {
            $.post('inventorySystem.php', {
                checkCost: $('#cost').val() //signals inventorySystem to what action to take
            }, function(data) {
                $('#costStatus').empty();
                $('#costStatus').append(data);
            });
        }
    });

    /**
     * On blur checks the inputted quantity for proper formatting
     * and displays any errors/messages to user.
     */
    $('#quantity').blur(function() {
        $('#quantityStatus').empty();
        if ($('#quantity').val() != '') {
            $.post('inventorySystem.php', {
                checkQuantity: $('#quantity').val() //signals inventorySystem to what action to take
            }, function(data) {
                $('#quantityStatus').empty();
                $('#quantityStatus').append(data);
            });
        }
    });

    /**
     * Loads the user's items upon load
     */
    loadProducts();
});

/**
 * Loads the user's items
 */
function loadProducts() {
    $.post('inventorySystem.php', {
        load: 1 //signals inventorySystem to what action to take
    }, function(data) {
        $('#shopInventory').empty();
        $('#shopInventory').append(data);
    });
}

/**
 * Removes the item attached to button
 */
function removeItem(elem) {
    $.post('inventorySystem', {
        removeId: elem.id //signals inventorySystem to what action to take
    }, function(data) {
        $('#addedStatus').empty();
        $('#addedStatus').append(data);
    });
    $('#' + elem.id).remove();
}

/**
 * function no longer used
 * The orginial program initially had a + and - button
 * to increase and decrease the quantity. This has been
 * replaced.
 */
function inc(elem) {
    var val = $('#' + elem.id + '>.quantity').text();

    $.post('inventorySystem.php', {
        incId: elem.id,         
        quantity: val.substring(10)
    }, function(data) {
        $('#addedStatus').empty();
        $('#' + elem.id + '>.quantity').text('Quantity: ' + data);
    });
}

/**
 * function no longer used
 * The orginial program initially had a + and - button
 * to increase and decrease the quantity. This has been
 * replaced.
 */
function dec(elem) {
    var val = $('#' + elem.id + '>.quantity').text();

    $.post('inventorySystem.php', {
        decId: elem.id,
        quantity: val.substring(10)
    }, function(data) {
        $('#addedStatus').empty();
        $('#' + elem.id + '>.quantity').text('Quantity: ' + data);
    });
}

/**
 * Updates the quantity of the item attached to the button
 */
function update(elem) {
    var val = $('#' + elem.id + '>.quantity').val();
    $.post('inventorySystem.php', {
        updateId: elem.id,
        quantity: val
    }, function(data) {
        $('#addedStatus').empty();
        $('#addedStatus').append(data);
    });
}
