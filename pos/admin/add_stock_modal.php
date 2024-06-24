<!-- Formulaire de confirmation pour ajouter du stock -->
<div id="addStockModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter du stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addStockForm">
                <div class="modal-body">
                    <input type="hidden" id="productId" name="productId">
                    <div class="form-group">
                        <label for="stockQty">Quantité à ajouter</label>
                        <input type="number" class="form-control" id="stockQty" name="stockQty" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>