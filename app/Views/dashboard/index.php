<div class="row">
    <div class="col-md-4">
        <div class="card text-bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Açık Siparişler</h5>
                <p class="card-text display-6"><?php echo $metrics['open_orders']; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Ürün Sayısı</h5>
                <p class="card-text display-6"><?php echo $metrics['product_count']; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-secondary mb-3">
            <div class="card-body">
                <h5 class="card-title">Müşteri Sayısı</h5>
                <p class="card-text display-6"><?php echo $metrics['customer_count']; ?></p>
            </div>
        </div>
    </div>
</div>
