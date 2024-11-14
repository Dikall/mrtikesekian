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
                <div class="card-body">
                    <form action="{{ route('miti.store') }}" method="POST">
                        @csrf

                        <!-- Risk Selection -->
                        <div class="form-group">
                            <label for="risk_id">Select Risk</label>
                            @if($risks->isEmpty())
                                <p>No available risks to assign mitigation.</p>
                            @else
                                <select name="risk_id" class="form-control" required id="risk-select" onchange="showRiskPreview()">
                                    <option value="">-- Select Risk --</option>
                                    @foreach($risks as $risk)
                                        <option value="{{ $risk->id }}" 
                                            data-kode="{{ $risk->kode }}" 
                                            data-faktor="{{ $risk->faktor }}" 
                                            data-kemungkinan="{{ $risk->kemungkinan }}" 
                                            data-dampak="{{ $risk->dampak }}" 
                                            data-level="{{ $risk->values->first()->level ?? 'N/A' }}">
                                            {{ $risk->faktor }} - {{ $risk->kemungkinan }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                        </div>

                        <!-- Risk Preview (Form yang Tidak Bisa Diedit) -->
                        <div id="risk-preview" style="display: none;">
                            <h5>Risk Preview:</h5>
                            <p><strong>Kode:</strong> <input type="text" id="preview-kode" class="form-control" readonly></p>
                            <p><strong>Faktor:</strong> <input type="text" id="preview-faktor" class="form-control" readonly></p>
                            <p><strong>Kemungkinan:</strong> <input type="text" id="preview-kemungkinan" class="form-control" readonly></p>
                            <p><strong>Dampak:</strong> <input type="text" id="preview-dampak" class="form-control" readonly></p>
                            <p><strong>Risk Level:</strong> <input type="text" id="preview-level" class="form-control" readonly></p>
                        </div>

                        <!-- Mitigation Input -->
                        <div class="form-group mt-3">
                            <label for="mitigasi">Mitigation</label>
                            <input type="text" name="mitigasi" class="form-control" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-primary">Add Mitigation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <x-app.footer />
    </main>

    <!-- JavaScript untuk Menampilkan Data Risiko dan Memasang Atribut readonly -->
    <script>
        function showRiskPreview() {
            var selectElement = document.getElementById('risk-select');
            var selectedOption = selectElement.options[selectElement.selectedIndex];

            // Ambil data dari option yang dipilih
            var kode = selectedOption.getAttribute('data-kode');
            var faktor = selectedOption.getAttribute('data-faktor');
            var kemungkinan = selectedOption.getAttribute('data-kemungkinan');
            var dampak = selectedOption.getAttribute('data-dampak');
            var level = selectedOption.getAttribute('data-level');

            // Masukkan data ke dalam input field
            document.getElementById('preview-kode').value = kode;
            document.getElementById('preview-faktor').value = faktor;
            document.getElementById('preview-kemungkinan').value = kemungkinan;
            document.getElementById('preview-dampak').value = dampak;
            document.getElementById('preview-level').value = level;

            // Menampilkan elemen preview
            document.getElementById('risk-preview').style.display = 'block';
        }
    </script>
</x-app-layout>
