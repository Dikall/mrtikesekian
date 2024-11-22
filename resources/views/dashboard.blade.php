<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.3.0/chart.min.js"></script>

        <div class="container-fluid py-4 px-5">
        

            <h1 class="mb-4">List of Risk Factors</h1>

            {{-- Pencarian --}}
            <form method="GET" action="{{ route('risk.index') }}" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" placeholder="Search..." class="form-control">
                </div>
            </form>

            <div class="card shadow-xs border mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="font-weight-semibold text-lg mb-0">Risk Factors Overview</h6>
                        <p class="text-sm mb-sm-0 mb-2">Here is the list of identified risk factors.</p>
                    </div>
                    <div class="d-flex">
                        <a href="{{ route('risk.create') }}" class="btn btn-primary">Add New Risk</a>
                        <a href="{{ route('value.create') }}" class="btn btn-primary ms-2">Add New Value</a>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Faktor</th>
                                    <th>Kemungkinan</th>
                                    <th>Dampak</th>
                                    <th>Likelihood</th>
                                    <th>Impact</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($risks as $risk)
                                    <tr>
                                        <td>{{ $risk->kode }}</td>
                                        <td>{{ $risk->faktor }}</td>
                                        <td>{{ $risk->kemungkinan }}</td>
                                        <td class="text-wrap">{{ $risk->dampak }}</td>
                                        <td>{{ optional($risk->values->first())->likelihood ?? 'N/A' }}</td>
                                        <td>{{ optional($risk->values->first())->impact ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('risk.edit', $risk->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('risk.destroy', $risk->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this risk?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Section for Risk Matrix -->
            <div class="card shadow-xs border mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="font-weight-semibold text-lg mb-0">Risk Matrix</h6>
                        <p class="text-sm mb-sm-0 mb-2">An overview of the risk matrix based on likelihood and impact.</p>
                    </div>
                    <div class="d-flex">
                        <a href="{{ route('miti.create') }}" class="btn btn-primary">Add Mitigation</a>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Faktor</th>
                                    <th>Kemungkinan Risiko</th>
                                    <th>Likelihood</th>
                                    <th>Impact</th>
                                    <th>Risk Level</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($matrixData as $risk)
                                    <tr>
                                        <td>{{ $risk['kode'] }}</td>
                                        <td>{{ $risk['faktor'] }}</td>
                                        <td>{{ $risk['kemungkinan'] }}</td>
                                        <td>{{ $risk['likelihood'] }}</td>
                                        <td>{{ $risk['impact'] }}</td>
                                        <td>
                                            @if($risk['risk_level'] == 'High')
                                                <span class="badge badge-danger">High</span>
                                            @elseif($risk['risk_level'] == 'Medium')
                                                <span class="badge badge-warning">Medium</span>
                                            @else
                                                <span class="badge badge-success">{{ $risk['risk_level'] }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card shadow-xs border mb-4">
                <div class="card-header pb-0">
                    <h6 class="font-weight-semibold text-lg mb-0">Risk Level Overview</h6>
                    <p class="text-sm mb-sm-0 mb-2">Visual representation of risk levels.</p>
                </div>
                <div class="card-body p-3">
                    <canvas id="riskChart" width="100%" height="200%"></canvas>
                </div>
            </div>

            <!-- Section for Mitigation Data -->
            <div class="card shadow-xs border mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="font-weight-semibold text-lg mb-0">Risk Mitigasi</h6>
                        <p class="text-sm mb-sm-0 mb-2">An overview of the Risk Mitigation.</p>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Faktor</th>
                                    <th>Kemungkinan Risiko</th>
                                    <th>Dampak</th>
                                    <th>Risk Level</th>
                                    <th>Mitigation</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($matrixData as $risk)
                                    <tr>
                                        <td>{{ $risk['kode'] }}</td>
                                        <td>{{ $risk['faktor'] }}</td>
                                        <td>{{ $risk['kemungkinan'] }}</td>
                                        <td class="text-wrap">{{ $risk['dampak'] }}</td>
                                        <td>
                                            @if($risk['risk_level'] == 'High')
                                                <span class="badge badge-danger">High</span>
                                            @elseif($risk['risk_level'] == 'Medium')
                                                <span class="badge badge-warning">Medium</span>
                                            @else
                                                <span class="badge badge-success">{{ $risk['risk_level'] }}</span>
                                            @endif
                                        </td>
                                        <td class="text-wrap">{{ $risk['mitigasi'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <x-app.footer />
    </main>
</x-app-layout>
