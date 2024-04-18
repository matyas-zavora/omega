function replaceWithInput(itemId, field) {
    const tdElement = document.getElementById(field + '-' + itemId);
    if (tdElement.innerHTML.trim() === '') {
        return;
    }
    if (tdElement.getElementsByTagName('input').length === 0) {
        let currentValue = tdElement.innerHTML.trim();
        currentValue = currentValue.replace(',00', '').replace(' Kč', '');
        const inputField = '<input type="number" class="form-control" name="' + field + '" placeholder="' + currentValue + '">';
        const submitButton = '<button class="btn btn-success mt-2">Submit</button>';
        tdElement.innerHTML = '<form action="' + field + '.php" method="post">' +
            '<input type="hidden" name="id" value="' + itemId + '"><div class="row m-2">' + inputField + submitButton + '</div></form>';
        tdElement.children[0].children[1].children[0].focus();
    }
}
