@extends('layouts.spk')

@section('title', 'Evaluasi Karir')
@section('subtitle', 'Isi kuisioner berikut untuk mendapatkan rekomendasi karir terbaik')

@section('content')

@php
$karirList = [
    'Web Developer', 'Mobile Developer', 'Data Analyst', 'Network Engineer',
    'UI/UX Designer', 'QA Engineer', 'Data Scientist', 'DevOps Engineer',
];
$karirIcons = [
    'Web Developer'=>'🌐','Mobile Developer'=>'📱','Data Analyst'=>'📊','Network Engineer'=>'🔌',
    'UI/UX Designer'=>'🎨','QA Engineer'=>'🛡️','Data Scientist'=>'⚙️','DevOps Engineer'=>'☁️',
];
$skillKategori = [
    '💻 Programming & Web' => ['HTML/CSS','JavaScript','TypeScript','PHP','Python','Java','Kotlin','C#'],
    '📱 Mobile Development' => ['Flutter/Dart','React Native','Swift','Android SDK','iOS Development','Firebase'],
    '🗄️ Database & Query'  => ['MySQL/PostgreSQL','MongoDB','SQL','NoSQL','Redis','Oracle'],
    '📊 Data & AI'          => ['Machine Learning','Deep Learning','Data Analysis','R','Tableau','Power BI','Excel/Spreadsheet','Statistika'],
    '🔌 Jaringan & Keamanan'=> ['TCP/IP','Linux Server','Cisco/MikroTik','Network Security','Firewall/VPN','Wireshark'],
    '🎨 Design & UX'        => ['Figma','Adobe XD','Canva Pro','UI Design','UX Research','Prototyping','Wireframing'],
    '☁️ DevOps & Cloud'     => ['Docker','Kubernetes','AWS/GCP/Azure','CI/CD Pipeline','Shell/Bash Scripting','Terraform','Ansible'],
    '🛡️ Testing & QA'       => ['Manual Testing','Selenium/Playwright','Postman','JIRA','Test Automation','JUnit/PyTest'],
    '🔧 Tools & Lainnya'    => ['Git/GitHub','REST API','GraphQL','Microservices','Agile/Scrum','Linux CLI'],
];
$pilihanSertif = ['Belum Ada'=>0,'1'=>1,'2'=>2,'3'=>3,'4'=>4,'5'=>5,'Lebih dari 5'=>6];
@endphp

@if(session('success'))
<div style="margin-bottom:20px;padding:14px 20px;background:rgba(34,197,94,0.12);border:1px solid rgba(34,197,94,0.3);border-radius:12px;color:var(--success);font-size:0.9rem;display:flex;align-items:center;gap:10px;">
    <span style="font-size:1.2rem;">✅</span> {{ session('success') }}
</div>
@endif
@if($errors->any())
<div style="margin-bottom:20px;padding:14px 20px;background:rgba(239,68,68,0.12);border:1px solid rgba(239,68,68,0.3);border-radius:12px;color:var(--danger);font-size:0.88rem;">
    <strong>Harap perbaiki:</strong>
    <ul style="margin:6px 0 0 16px;padding:0;">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
</div>
@endif

{{-- Progress indicator --}}
<div class="card fade-in" style="margin-bottom:24px;padding:20px 24px;">
    <div style="display:flex;align-items:center;gap:0;overflow-x:auto;">
        @foreach(['Skill Teknis','Minat Karir','Proyek','Sertifikasi'] as $idx => $step)
        <div style="display:flex;align-items:center;flex:1;min-width:80px;">
            <div style="display:flex;flex-direction:column;align-items:center;gap:4px;">
                <div style="width:32px;height:32px;border-radius:50%;background:rgba(99,102,241,0.15);border:2px solid rgba(99,102,241,0.4);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.82rem;color:var(--primary-light);">{{ $idx+1 }}</div>
                <span style="font-size:0.7rem;color:var(--text-secondary);white-space:nowrap;">{{ $step }}</span>
            </div>
            @if($idx < 3)
            <div style="flex:1;height:2px;background:rgba(99,102,241,0.2);margin:0 4px;margin-bottom:16px;"></div>
            @endif
        </div>
        @endforeach
    </div>
</div>

<form method="POST" action="{{ route('penilaian-kriteria.store') }}" id="kuisionerForm">
@csrf

{{-- ============================
     BAGIAN 1: SKILL TEKNIS
============================= --}}
<div class="card fade-in" style="margin-bottom:24px;">
    <div style="display:flex;align-items:flex-start;gap:16px;margin-bottom:20px;padding-bottom:16px;border-bottom:1px solid var(--border);">
        <div style="width:44px;height:44px;border-radius:14px;background:linear-gradient(135deg,var(--primary),var(--secondary));display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0;">💻</div>
        <div style="flex:1;">
            <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                <h3 style="font-weight:700;margin:0;font-size:1.05rem;">Skill dan Kemampuan Teknis</h3>
                <span style="font-size:0.75rem;padding:2px 10px;background:rgba(239,68,68,0.15);color:var(--danger);border-radius:20px;font-weight:600;">Opsional</span>
            </div>
            <p style="color:var(--text-secondary);font-size:0.83rem;margin:4px 0 0;">Centang semua skill yang kamu kuasai. Contoh: Figma, HTML, Java, Python, dll.</p>
        </div>
        <div style="text-align:right;flex-shrink:0;">
            <div id="skillCount" style="font-size:1.4rem;font-weight:800;color:var(--primary-light);">0</div>
            <div style="font-size:0.72rem;color:var(--text-secondary);">skill dipilih</div>
        </div>
    </div>

    @foreach($skillKategori as $kategori => $skills)
    <div style="margin-bottom:18px;">
        <div style="font-size:0.78rem;font-weight:700;color:var(--text-secondary);margin-bottom:8px;letter-spacing:0.5px;text-transform:uppercase;">{{ $kategori }}</div>
        <div style="display:flex;flex-wrap:wrap;gap:8px;">
            @foreach($skills as $skill)
            <label class="skill-chip">
                <input type="checkbox" name="skills[]" value="{{ $skill }}"
                    onchange="updateSkillCount()"
                    {{ in_array($skill, $savedSkills ?? []) ? 'checked' : '' }}>
                <span class="chip-inner">
                    <span class="chip-check">✓</span>
                    {{ $skill }}
                </span>
            </label>
            @endforeach
        </div>
    </div>
    @endforeach
</div>

{{-- ============================
     BAGIAN 2: MINAT KARIR
============================= --}}
<div class="card fade-in fade-in-delay-1" style="margin-bottom:24px;">
    <div style="display:flex;align-items:flex-start;gap:16px;margin-bottom:20px;padding-bottom:16px;border-bottom:1px solid var(--border);">
        <div style="width:44px;height:44px;border-radius:14px;background:linear-gradient(135deg,#f59e0b,#d97706);display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0;">⭐</div>
        <div>
            <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                <h3 style="font-weight:700;margin:0;font-size:1.05rem;">Minat terhadap Bidang <span style="font-style:italic;color:var(--text-secondary);font-size:0.9rem;">(Passion)</span></h3>
                <span style="font-size:0.75rem;padding:2px 10px;background:rgba(239,68,68,0.15);color:var(--danger);border-radius:20px;font-weight:600;">Wajib</span>
            </div>
            <p style="color:var(--text-secondary);font-size:0.83rem;margin:4px 0 0;">Pilih jalur karir yang paling dan kedua paling kamu minati.</p>
        </div>
    </div>

    <div class="grid-2" style="gap:20px;">
        {{-- Pilihan 1 --}}
        <div>
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                <div style="width:26px;height:26px;border-radius:50%;background:linear-gradient(135deg,#fbbf24,#f59e0b);display:flex;align-items:center;justify-content:center;font-size:0.85rem;font-weight:800;color:#78350f;">1</div>
                <div>
                    <div style="font-weight:700;font-size:0.92rem;">Pilihan Pertama</div>
                    <div style="font-size:0.75rem;color:var(--text-secondary);">Karir yang paling kamu inginkan</div>
                </div>
            </div>
            <div style="display:flex;flex-direction:column;gap:6px;">
                @foreach($alternatifs as $alt)
                <label class="karir-option karir-option-1" data-id="{{ $alt->id }}">
                    <input type="radio" name="minat_1" value="{{ $alt->id }}"
                        onchange="handleMinat1Change({{ $alt->id }})"
                        {{ ($savedMinat1 ?? '') == $alt->id ? 'checked' : '' }}>
                    <span class="karir-icon">{{ $karirIcons[$alt->nama] ?? '💼' }}</span>
                    <span class="karir-nama">{{ $alt->nama }}</span>
                    <span class="karir-check">✓</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Pilihan 2 --}}
        <div>
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                <div style="width:26px;height:26px;border-radius:50%;background:linear-gradient(135deg,#a78bfa,#7c3aed);display:flex;align-items:center;justify-content:center;font-size:0.85rem;font-weight:800;color:white;">2</div>
                <div>
                    <div style="font-weight:700;font-size:0.92rem;">Pilihan Kedua</div>
                    <div style="font-size:0.75rem;color:var(--text-secondary);">Karir alternatif yang kamu sukai</div>
                </div>
            </div>
            <div style="display:flex;flex-direction:column;gap:6px;">
                @foreach($alternatifs as $alt)
                <label class="karir-option karir-option-2" data-id="{{ $alt->id }}">
                    <input type="radio" name="minat_2" value="{{ $alt->id }}"
                        onchange="handleMinat2Change({{ $alt->id }})"
                        {{ ($savedMinat2 ?? '') == $alt->id ? 'checked' : '' }}>
                    <span class="karir-icon">{{ $karirIcons[$alt->nama] ?? '💼' }}</span>
                    <span class="karir-nama">{{ $alt->nama }}</span>
                    <span class="karir-check">✓</span>
                </label>
                @endforeach
            </div>
            <div id="minatWarning" style="display:none;margin-top:8px;padding:10px 14px;background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.3);border-radius:10px;font-size:0.8rem;color:var(--warning);">
                ⚠️ Pilihan 2 tidak boleh sama dengan Pilihan 1
            </div>
        </div>
    </div>
</div>

{{-- ============================
     BAGIAN 3 & 4 SEJAJAR
============================= --}}
<div class="grid-2" style="gap:24px;margin-bottom:24px;">

    {{-- Proyek Mandiri --}}
    <div class="card fade-in fade-in-delay-2">
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;padding-bottom:16px;border-bottom:1px solid var(--border);">
            <div style="width:44px;height:44px;border-radius:14px;background:linear-gradient(135deg,#06b6d4,#0891b2);display:flex;align-items:center;justify-content:center;font-size:1.3rem;">📁</div>
            <div>
                <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                    <h3 style="font-weight:700;margin:0;font-size:0.95rem;">Proyek Mandiri</h3>
                    <span style="font-size:0.72rem;padding:2px 8px;background:rgba(239,68,68,0.15);color:var(--danger);border-radius:20px;font-weight:600;">Wajib</span>
                </div>
                <p style="color:var(--text-secondary);font-size:0.78rem;margin:2px 0 0;">Berapa proyek/tugas besar yang sudah dikerjakan?</p>
            </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;" id="proyekGrid">
            @php $proyekOpts = ['Belum Ada'=>0,'1 Proyek'=>1,'2 Proyek'=>2,'3 Proyek'=>3,'4 Proyek'=>4,'5 Proyek'=>5,'Lebih dari 5'=>6]; @endphp
            @foreach($proyekOpts as $label => $val)
            <label class="count-option {{ ($savedProyek ?? -1) == $val ? 'count-selected' : '' }}" onclick="selectCount(this, 'proyek')">
                <input type="radio" name="proyek" value="{{ $val }}" {{ ($savedProyek ?? -1) == $val ? 'checked' : '' }} style="display:none;">
                <span class="count-num">{{ $val == 6 ? '5+' : $val }}</span>
                <span class="count-label">{{ $label }}</span>
            </label>
            @endforeach
        </div>
    </div>

    {{-- Sertifikasi --}}
    <div class="card fade-in fade-in-delay-3">
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;padding-bottom:16px;border-bottom:1px solid var(--border);">
            <div style="width:44px;height:44px;border-radius:14px;background:linear-gradient(135deg,#22c55e,#16a34a);display:flex;align-items:center;justify-content:center;font-size:1.3rem;">📜</div>
            <div>
                <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                    <h3 style="font-weight:700;margin:0;font-size:0.95rem;">Sertifikasi / Pengalaman</h3>
                    <span style="font-size:0.72rem;padding:2px 8px;background:rgba(239,68,68,0.15);color:var(--danger);border-radius:20px;font-weight:600;">Wajib</span>
                </div>
                <p style="color:var(--text-secondary);font-size:0.78rem;margin:2px 0 0;">Jumlah sertifikat IT atau pengalaman kerja/magang</p>
            </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;" class="sertif-grid">
            @php $sertifOpts = ['Belum Ada'=>0,'1 Sertifikat'=>1,'2 Sertifikat'=>2,'3 Sertifikat'=>3,'4 Sertifikat'=>4,'5 Sertifikat'=>5,'Lebih dari 5'=>6]; @endphp
            @foreach($sertifOpts as $label => $val)
            <label class="count-option {{ ($savedSertifikasi ?? -1) == $val ? 'count-selected' : '' }}" onclick="selectCount(this, 'sertifikasi')">
                <input type="radio" name="sertifikasi" value="{{ $val }}" {{ ($savedSertifikasi ?? -1) == $val ? 'checked' : '' }} style="display:none;">
                <span class="count-num">{{ $val == 6 ? '5+' : $val }}</span>
                <span class="count-label">{{ $label }}</span>
            </label>
            @endforeach
        </div>
    </div>

</div>

{{-- ============================
     TOMBOL SUBMIT
============================= --}}
<div class="card fade-in" style="padding:32px;text-align:center;background:linear-gradient(135deg,rgba(99,102,241,0.08),rgba(139,92,246,0.05));border-color:rgba(99,102,241,0.3);">
    <div style="font-size:2rem;margin-bottom:10px;">📋</div>
    <h3 style="font-weight:700;margin:0 0 6px;">Siap Mendapatkan Rekomendasi?</h3>
    <p style="color:var(--text-secondary);font-size:0.85rem;margin:0 0 20px;">Pastikan minat (⭐), proyek (📁), dan sertifikasi (📜) sudah dipilih.</p>
    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
        <a href="{{ route('nilai.create') }}" class="btn-secondary">← Kembali ke Nilai</a>
        <button type="submit" class="btn-primary" style="padding:12px 36px;font-size:1rem;" id="submitBtn">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Simpan Jawaban
        </button>
    </div>
</div>

</form>

{{-- Hitung Rekomendasi --}}
@if($penilaianTersimpan->count() > 0)
<div class="card fade-in" style="margin-top:20px;text-align:center;border-color:rgba(34,197,94,0.4);box-shadow:0 0 20px rgba(34,197,94,0.1);padding:28px;">
    <div style="font-size:2rem;margin-bottom:8px;">✨</div>
    <h3 style="font-weight:700;margin:0 0 6px;">Data Tersimpan!</h3>
    <p style="color:var(--text-secondary);font-size:0.85rem;margin:0 0 20px;">Klik tombol di bawah untuk menghitung rekomendasi karir menggunakan <strong>AHP + TOPSIS</strong>.</p>
    <form action="{{ route('penilaian-kriteria.calculate') }}" method="POST">
        @csrf
        <button type="submit" class="btn-primary" style="background:linear-gradient(135deg,var(--success),#16a34a);padding:14px 40px;font-size:1rem;">
            🚀 Hitung Rekomendasi Karir
        </button>
    </form>
</div>
@endif

{{-- CSS --}}
<style>
/* ====== Mobile Responsive ====== */
@media (max-width: 768px) {
    #proyekGrid, .sertif-grid {
        grid-template-columns: repeat(3, 1fr) !important;
    }
    .count-label { font-size: 0.6rem; }
    .karir-nama { font-size: 0.8rem; }
    .chip-inner { font-size: 0.78rem; padding: 5px 10px; }
}
@media (max-width: 480px) {
    #proyekGrid, .sertif-grid {
        grid-template-columns: repeat(2, 1fr) !important;
    }
}

/* ====== Skill Chips ====== */
.skill-chip { display:inline-flex; cursor:pointer; }
.skill-chip input { display:none; }
.chip-inner {
    display:flex; align-items:center; gap:6px;
    padding:6px 14px; border-radius:20px;
    border:1.5px solid var(--border);
    background:var(--bg-dark);
    font-size:0.82rem; color:var(--text-secondary);
    transition:all 0.15s; user-select:none;
}
.chip-check { font-size:0.7rem; opacity:0; transition:opacity 0.15s; }
.skill-chip input:checked ~ .chip-inner {
    background:rgba(99,102,241,0.2);
    border-color:var(--primary);
    color:var(--primary-light);
}
.skill-chip input:checked ~ .chip-inner .chip-check { opacity:1; }
.skill-chip:hover .chip-inner { border-color:rgba(99,102,241,0.5); }

/* ====== Karir Options ====== */
.karir-option {
    display:flex; align-items:center; gap:10px;
    padding:10px 14px; border-radius:12px;
    border:1.5px solid var(--border);
    background:var(--bg-dark); cursor:pointer;
    transition:all 0.15s;
}
.karir-option input { display:none; }
.karir-icon { font-size:1.2rem; flex-shrink:0; }
.karir-nama { flex:1; font-size:0.85rem; font-weight:500; }
.karir-check {
    width:20px; height:20px; border-radius:50%;
    background:rgba(99,102,241,0.1); border:1.5px solid var(--border);
    display:flex; align-items:center; justify-content:center;
    font-size:0.65rem; flex-shrink:0; opacity:0.4; transition:all 0.15s;
}
.karir-option:hover { border-color:rgba(99,102,241,0.4); background:rgba(99,102,241,0.04); }
.karir-option.selected-1 { border-color:#f59e0b; background:rgba(245,158,11,0.08); }
.karir-option.selected-1 .karir-check { background:#f59e0b; border-color:#f59e0b; color:#fff; opacity:1; }
.karir-option.selected-2 { border-color:var(--accent); background:rgba(139,92,246,0.08); }
.karir-option.selected-2 .karir-check { background:var(--accent); border-color:var(--accent); color:#fff; opacity:1; }

/* ====== Count Options (Proyek & Sertifikasi) ====== */
.count-option {
    display:flex; flex-direction:column; align-items:center; gap:2px;
    padding:12px 8px; border-radius:12px;
    border:1.5px solid var(--border);
    background:var(--bg-dark); cursor:pointer;
    transition:all 0.15s; text-align:center;
}
.count-option:hover { border-color:rgba(99,102,241,0.4); transform:translateY(-1px); }
.count-option.count-selected {
    border-color:var(--primary);
    background:rgba(99,102,241,0.15);
    box-shadow:0 0 12px rgba(99,102,241,0.2);
}
.count-num {
    font-size:1.4rem; font-weight:800;
    color:var(--text-secondary); transition:color 0.15s;
}
.count-selected .count-num { color:var(--primary-light); }
.count-label { font-size:0.68rem; color:var(--text-secondary); white-space:nowrap; }
</style>

@endsection

@section('scripts')
<script>
// ===== Skill chips =====
function updateSkillCount() {
    const n = document.querySelectorAll('input[name="skills[]"]:checked').length;
    document.getElementById('skillCount').textContent = n;
    document.getElementById('skillCount').style.color = n > 0 ? 'var(--primary-light)' : 'var(--text-secondary)';
}
updateSkillCount();

// ===== Minat =====
let minat1Val = {{ $savedMinat1 ?? 'null' }};
let minat2Val = {{ $savedMinat2 ?? 'null' }};

function syncMinatStyles() {
    document.querySelectorAll('.karir-option-1').forEach(lbl => {
        const id = parseInt(lbl.dataset.id);
        lbl.classList.toggle('selected-1', id === minat1Val);
    });
    document.querySelectorAll('.karir-option-2').forEach(lbl => {
        const id = parseInt(lbl.dataset.id);
        lbl.classList.toggle('selected-2', id === minat2Val);
    });
}
syncMinatStyles();

function handleMinat1Change(id) {
    minat1Val = id;
    if (minat1Val === minat2Val) {
        document.getElementById('minatWarning').style.display = 'block';
        document.querySelector(`input[name="minat_2"][value="${id}"]`).checked = false;
        minat2Val = null;
    } else {
        document.getElementById('minatWarning').style.display = 'none';
    }
    syncMinatStyles();
}
function handleMinat2Change(id) {
    if (id === minat1Val) {
        document.getElementById('minatWarning').style.display = 'block';
        document.querySelector(`input[name="minat_2"][value="${id}"]`).checked = false;
        return;
    }
    document.getElementById('minatWarning').style.display = 'none';
    minat2Val = id;
    syncMinatStyles();
}

// ===== Count Options (Proyek & Sertifikasi) =====
function selectCount(lbl, name) {
    const group = lbl.closest('div');
    group.querySelectorAll('.count-option').forEach(l => l.classList.remove('count-selected'));
    lbl.classList.add('count-selected');
    lbl.querySelector('input').checked = true;
}

// ===== Form Validation =====
document.getElementById('kuisionerForm').addEventListener('submit', function(e) {
    const m1 = document.querySelector('input[name="minat_1"]:checked');
    const m2 = document.querySelector('input[name="minat_2"]:checked');
    const pr = document.querySelector('input[name="proyek"]:checked');
    const sf = document.querySelector('input[name="sertifikasi"]:checked');
    const msgs = [];
    if (!m1) msgs.push('⭐ Pilih Minat Pilihan Pertama');
    if (!m2) msgs.push('🔹 Pilih Minat Pilihan Kedua');
    if (!pr) msgs.push('📁 Pilih jumlah proyek mandiri');
    if (!sf) msgs.push('📜 Pilih jumlah sertifikasi');
    if (msgs.length) { e.preventDefault(); alert('Harap lengkapi:\n• ' + msgs.join('\n• ')); }
});
</script>
@endsection
