<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <div class="container-fluid py-4 px-5">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card shadow-xs border">
                <div class="card-header pb-0">
                    <h6 class="font-weight-semibold text-lg mb-0">Add New Risk Factor</h6>
                    <p class="text-sm mb-sm-0 mb-2">Fill out the form below to add a new risk factor.</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('risk.store') }}" method="POST">
                        @csrf

                        <!-- Kode Input -->
                        <div class="form-group mb-3">
                            <label for="kode" class="form-label">Kode</label>
                            <input type="text" name="kode" class="form-control" required>
                        </div>

                        <!-- Faktor Selection -->
                        <div class="form-group mb-3">
                            <label for="faktor" class="form-label">Faktor</label>
                            <select name="faktor" class="form-control" required>
                                <option value="Alam atau Lingkungan">Alam atau Lingkungan</option>
                                <option value="Manusia">Manusia</option>
                                <option value="Sistem dan Infrastruktur">Sistem dan Infrastruktur</option>
                            </select>
                        </div>

                        <!-- Kemungkinan Risiko Input -->
                        <div class="form-group mb-3">
                            <label for="kemungkinan" class="form-label">Kemungkinan Risiko</label>
                            <input type="text" name="kemungkinan" class="form-control" required>
                        </div>

                        <!-- Dampak Input -->
                        <div class="form-group mb-3">
                            <label for="dampak" class="form-label">Dampak</label>
                            <input type="text" name="dampak" class="form-control" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Add Risk Factor</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <x-app.footer />
    </main>
</x-app-layout>
