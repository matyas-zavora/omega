/**
 * Replaces the content of a table cell with an input field for editing.
 * @param {string} itemId - The ID of the item being edited.
 * @param {string} field - The field to be edited (e.g., "price" or "quantity").
 */
function replaceWithInput(itemId, field) {
    // Get the table cell element
    const tdElement = document.getElementById(field + '-' + itemId);

    // If the table cell is empty, return
    if (tdElement.innerHTML.trim() === '') {
        return;
    }

    // If the table cell doesn't already contain an input field
    if (tdElement.getElementsByTagName('input').length === 0) {
        // Get the current value and format it
        let currentValue = tdElement.innerHTML.trim();
        currentValue = currentValue.replace(',00', '').replace(' Kč', '');

        // Create the input field and submit button HTML
        const inputField = '<input type="number" class="form-control" name="' + field + '" placeholder="' + currentValue + '">';
        const submitButton = '<button class="btn btn-success mt-2">Submit</button>';

        // Replace the content of the table cell with a form containing the input field and submit button
        tdElement.innerHTML = '<form action="' + field + '.php" method="post">' +
            '<input type="hidden" name="id" value="' + itemId + '"><div class="row m-2">' + inputField + submitButton + '</div></form>';

        // Focus on the input field
        tdElement.querySelector('input').focus();
    }
}
