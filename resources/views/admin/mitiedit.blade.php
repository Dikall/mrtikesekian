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
                <form action="{{ route('miti.update', $miti->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Risk Selection -->
                    <div class="form-group">
                        <label for="risk_id">Select Risk</label>
                        <select name="risk_id" class="form-control" required>
                            <option value="">-- Select Risk --</option>
                            @foreach($risks as $risk)
                                <option value="{{ $risk->id }}" 
                                    {{ $risk->id == $miti->risk_id ? 'selected' : '' }}>
                                    {{ $risk->faktor }} - {{ $risk->kemungkinan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Mitigation Input -->
                    <div class="form-group mt-3">
                        <label for="mitigasi">Mitigation</label>
                        <input type="text" name="mitigasi" class="form-control" value="{{ $miti->mitigasi }}" required>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group text-center mt-4">
                        <button type="submit" class="btn btn-primary">Update Mitigation</button>
                    </div>
                </form>

                </div>
            </div>
        </div>
        <x-app.footer />
    </main>
</x-app-layout>
