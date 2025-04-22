$(document).ready(function () {
    // Gestion du client
    $('#clientSelect').on('change', function () {
        const id = $(this).val();
        const selectedOption = $(this).find('option:selected');
        
        if (id) {
            $('#clientBadge').removeClass('d-none');
            $('#clientName').text(selectedOption.data('nom'));
            $('#clientPhone').text(selectedOption.data('tel'));
            $('#clientCity').text(selectedOption.data('ville'));
            
            $('#modalCodeClient').text(id);
            $('#modalNomClient').text(selectedOption.data('nom'));
            $('#modalTelClient').text(selectedOption.data('tel'));
            $('#modalVilleClient').text(selectedOption.data('ville'));
            $('#modalEmailClient').text(selectedOption.data('email'));
            $('#modalAdresseClient').text(selectedOption.data('adresse'));
        } else {
            $('#clientBadge').addClass('d-none');
        }
    });

    $('#btnMoreInfo').on('click', function() {
        $('#clientModal').modal('show');
    });

    // Pavé numérique
    $('#numPad').on('click', '.num-btn', function() {
        const clickedValue = $(this).data('value');
        const inputField = $('#inputQte');
        let currentValue = inputField.val();

        if (currentValue === '0' || currentValue === '1') {
            inputField.val(clickedValue);
        } else {
            inputField.val(currentValue + clickedValue);
        }
        inputField.focus();
    });

    $('#btnClear').on('click', function() {
        $('#inputQte').val('1').focus();
    });

    // Recherche et ajout de produit
    let index = 1;
    
    function addProductToTable(product) {
        let qte = parseInt($('#inputQte').val()) || 1;
        if (qte < 1) qte = 1;
        
        const remise = parseInt($('#inputRemise').val()) || 0;
        const total = (product.price - (product.price * remise / 100)) * qte;

        const row = `
            <tr data-reference="${product.reference}">
                <td class="text-center">${index}</td>
                <td class="text-center">${product.reference}</td>
                <td>${product.name}</td>
                <td class="text-center">${qte}</td>
                <td class="text-center">${product.price} DH</td>
                <td class="text-center">${remise}%</td>
                <td class="text-center">${total.toFixed(2)} DH</td>
                <td class="text-center">
                    <button class="btn btn-danger btn-sm remove-item">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        `;

        $('#tableItems tbody').append(row);
        updateTotal();
        index++;
        $('#inputQte').val('1');
        $('#inputSearch').val('').focus();
    }

    // Ajout via bouton
    $('#btnAddItem').on('click', function() {
        const ref = $('#inputSearch').val().trim();
        if (!ref) return;

        $.get('/produit/find/' + ref)
            .done(addProductToTable)
            .fail(function() {
                alert('Produit introuvable');
            });
    });

    // Ajout via touche Entrée
    $('#inputSearch').on('keypress', function(e) {
        if (e.which === 13) {
            $('#btnAddItem').click();
        }
    });

    // Suppression de ligne
    $(document).on('click', '.remove-item', function() {
        $(this).closest('tr').remove();
        updateTotal();
    });

    // Mise à jour du total
    function updateTotal() {
        let total = 0;
        $('#tableItems tbody tr').each(function() {
            const t = parseFloat($(this).find('td:nth-child(7)').text().replace(' DH', ''));
            if (!isNaN(t)) total += t;
        });
        $('#totalAmount').text(total.toFixed(2) + ' DH');
    }

    // Enregistrement de la vente
    $('#btnSubmit').on('click', function () {
    const clientId = $('#clientSelect').val();

    if (!clientId) {
        alert('Veuillez sélectionner un client');
        return;
    }

    const items = [];
    $('#tableItems tbody tr').each(function () {
        items.push({
            reference: $(this).data('reference'),
            name: $(this).find('td:nth-child(3)').text(),
            quantity: parseInt($(this).find('td:nth-child(4)').text()),
            price: parseFloat($(this).find('td:nth-child(5)').text().replace(' DH', '')),
            discount: parseInt($(this).find('td:nth-child(6)').text().replace('%', ''))
        });
    });

    if (items.length === 0) {
        alert('Veuillez ajouter au moins un produit');
        return;
    }

    const totalAmount = parseFloat($('#totalAmount').text().replace(' DH', ''));

    $.ajax({
        url: '/commandes',
        method: 'POST',
        data: {
            client_id: clientId,
            items: items,
            total: totalAmount,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
            alert(res.message);
            $('#clientSelect').val('').trigger('change');
            $('#tableItems tbody').empty();
            updateTotal();
            index = 1;
        },
        error: function (err) {
            console.error(err);
            alert('Erreur: ' + (err.responseJSON?.message || 'Erreur inconnue'));
        }
    });
});

    // Impression
    $('#btnPrint').on('click', function() {
        window.print();
    });
});