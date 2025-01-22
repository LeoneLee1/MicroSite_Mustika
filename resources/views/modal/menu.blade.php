<!-- Modal -->
<div class="modal fade" id="menu" tabindex="-1" aria-labelledby="menuLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg rounded">
            <!-- Header Modal -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="menuLabel" style="color: white;">
                    <i class="fa fa-layer-group"></i> Pendarrasa Services
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <!-- Body Modal -->
            <div class="modal-body">
                <div class="row g-3 text-center">
                    <!-- Menu Item -->
                    <div class="col-6">
                        <a href="{{ route('analysis') }}" class="menu-item">
                            <div class="icon-box bg-success">
                                <i class="fa fa-chart-bar"></i>
                            </div>
                            <p>Analysis</p>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('user') }}" class="menu-item">
                            <div class="icon-box bg-primary">
                                <i class="fa fa-users"></i>
                            </div>
                            <p>User</p>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('user.regis') }}" class="menu-item">
                            <div class="icon-box bg-warning">
                                <i class="fa fa-user-tag"></i>
                            </div>
                            <p>Registrasi</p>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('log') }}" class="menu-item">
                            <div class="icon-box bg-danger">
                                <i class="fa fa-clock-rotate-left"></i>
                            </div>
                            <p>Log History</p>
                        </a>
                    </div>
                    @if (Auth::user()->nik === 'daniel.it')
                        <div class="col-6">
                            <a href="{{ route('admin.postingan') }}" class="menu-item">
                                <div class="icon-box bg-secondary">
                                    <i class="fa fa-cog"></i>
                                </div>
                                <p>ADMIN</p>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS -->
<style>
    .menu-item {
        display: block;
        text-decoration: none;
        color: #333;
        transition: all 0.3s ease;
    }

    .menu-item:hover {
        transform: translateY(-5px);
        color: #007bff;
    }

    .icon-box {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        border-radius: 10px;
        color: white;
        font-size: 24px;
        transition: all 0.3s ease;
    }

    .menu-item:hover .icon-box {
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        border-bottom: none;
    }

    .modal-content {
        border-radius: 15px;
    }
</style>
