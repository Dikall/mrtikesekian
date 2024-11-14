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
                    <form action="{{ route('value.store') }}" method="POST">
                        @csrf

                        <!-- Risk Selection -->
                        <div class="form-group">
                            <label for="risks_id">Select Risk</label>
                            @if($risks->isEmpty())
                                <p>No available risks to assign a value.</p>
                            @else
                                <select name="risks_id" class="form-control" required>
                                    @foreach($risks as $risk)
                                        <option value="{{ $risk->id }}">{{ $risk->faktor }} - {{ $risk->kemungkinan }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>

                        <!-- Likelihood Input -->
                        <div class="form-group">
                            <label for="likelihood">Likelihood (1-5)</label>
                            <input type="number" name="likelihood" class="form-control" min="1" max="5" required>
                        </div>

                        <!-- Impact Input -->
                        <div class="form-group">
                            <label for="impact">Impact (1-5)</label>
                                <input type="number" name="impact" class="form-control" min="1" max="5" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Add Value</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <x-app.footer />
    </main>
</x-app-layout>
