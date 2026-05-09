<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 bg-primary bg-gradient text-white">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">کل درخواست‌ها</h6>
                        <h3 class="text-white fw-bold mb-0">{{ number_format($totalCount ?? $requests->total()) }}</h3>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-2">
                        <i class="bi bi-files fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 bg-warning bg-gradient text-white">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">در انتظار بررسی</h6>
                        <h3 class="text-white fw-bold mb-0">{{ number_format($pendingCount ?? 0) }}</h3>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-2">
                        <i class="bi bi-clock-history fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 bg-success bg-gradient text-white">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">تایید شده</h6>
                        <h3 class="text-white fw-bold mb-0">{{ number_format($approvedCount ?? 0) }}</h3>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-2">
                        <i class="bi bi-check-circle fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 bg-danger bg-gradient text-white">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">رد شده</h6>
                        <h3 class="text-white fw-bold mb-0">{{ number_format($rejectedCount ?? 0) }}</h3>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-2">
                        <i class="bi bi-x-circle fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>