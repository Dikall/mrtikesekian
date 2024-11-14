<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <div class="container-fluid py-4 px-5">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <h1 class="mb-4">Edit Risk Factor and Values</h1>

            <div class="card shadow-xs border">
                <div class="card-body">
                    <form action="{{ route('risk.update', $factor->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Faktor Risiko Input -->
                        <div class="form-group">
                            <label for="faktor">Faktor Risiko</label>
                            <select name="faktor" class="form-control" required>
                            <option value="Alam atau Lingkungan" {{ $factor->faktor == 'Alam atau Lingkungan' ? 'selected' : '' }}>Alam atau Lingkungan</option>
                            <option value="Manusia" {{ $factor->faktor == 'Manusia' ? 'selected' : '' }}>Manusia</option>
                            <option value="Sistem dan Infrastruktur" {{ $factor->faktor == 'Sistem dan Infrastruktur' ? 'selected' : '' }}>Sistem dan Infrastruktur</option>
                        </select>
                        </div>
                        
                        <!-- Kemungkinan Risiko Input -->
                        <div class="form-group">
                            <label for="kemungkinan">Kemungkinan Risiko</label>
                            <input type="text" name="kemungkinan" class="form-control" value="{{ $factor->kemungkinan }}" required>
                        </div>

                        <!-- Dampak Input -->
                        <div class="form-group">
                            <label for="dampak">Dampak</label>
                            <input type="text" name="dampak" class="form-control" value="{{ $factor->dampak }}" required>
                        </div>

                        <!-- Likelihood Input -->
                        <div class="form-group">
                            <label for="likelihood">Likelihood (1-5)</label>
                            <input type="number" name="likelihood" class="form-control" value="{{ optional($factor->values->first())->likelihood }}" min="1" max="5" required>
                        </div>

                        <!-- Impact Input -->
                        <div class="form-group">
                            <label for="impact">Impact (1-5)</label>
                            <input type="number" name="impact" class="form-control" value="{{ optional($factor->values->first())->impact }}" min="1" max="5" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Update Risk and Values</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <x-app.footer />
    </main>
</x-app-layout>
