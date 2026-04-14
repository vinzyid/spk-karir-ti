@extends('layouts.spk')

@section('title', 'Evaluasi Kriteria Karir')
@section('subtitle', 'Pilih skill, tingkat minat, dan sertifikasi untuk setiap jalur karir')

@section('content')

@php
$skillSets = [
    'Web Developer'      => ['HTML/CSS', 'JavaScript', 'PHP', 'MySQL', 'React/Vue.js', 'Bootstrap', 'REST API', 'Git'],
    'Mobile Developer'   => ['Kotlin/Java', 'Flutter/Dart', 'Swift', 'React Native', 'Android SDK', 'iOS SDK', 'Firebase', 'Git'],
    'Data Analyst'       => ['SQL', 'Python', 'Excel', 'Tableau', 'Power BI', 'Statistika', 'Data Cleaning', 'R'],
    'Network Engineer'   => ['TCP/IP', 'Cisco/MikroTik', 'Network Security', 'Linux Server', 'Firewall', 'VPN', 'Routing', 'Switching'],
    'UI/UX Designer'     => ['Figma', 'Adobe XD', 'User Research', 'Wireframing', 'Prototyping', 'Design System', 'HTML/CSS', 'Usability Testing'],
    'QA Engineer'        => ['Manual Testing', 'Selenium', 'JIRA', 'Bug Reporting', 'Test Automation', 'Postman', 'Test Planning', 'Python/Java'],
    'Data Scientist'     => ['Python', 'R', 'Machine Learning', 'Deep Learning', 'TensorFlow/PyTorch', 'Statistika', 'SQL', 'Data Wrangling'],
    'DevOps Engineer'    => ['Docker', 'Kubernetes', 'AWS/GCP/Azure', 'CI/CD Pipeline', 'Linux', 'Shell Scripting', 'Terraform', 'Git'],
];

$minatLabels = ['', 'Sangat Tidak Minat', 'Tidak Minat', 'Netral', 'Minat', 'Sangat Minat'];
@endphp

{{-- Alur Pengisian --}}
<div class="card fade-in" style="margin-bottom: 20px; border-color: rgba(99,102,241,0.3);">
    <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
        <div style="font-size: 2rem;">📋</div>
        <div>
            <h3 style="font-weight: 700; margin-bottom: 6px;">Cara Pengisian</h3>
            <div style="display: flex; gap: 20px; flex-wrap: wrap; font-size: 0.85rem; color: var(--text-secondary);">
                <span>🟣 <strong>Skill:</strong> Klik skill yang kamu kuasai</span>
                <span>⭐ <strong>Minat:</strong> Klik bintang 1–5</span>
                <span>📜 <strong>Sertifikasi:</strong> Ketik nama sertifikat yang kamu punya</span>
            </div>
        </div>
    </div>
</div>

@if($alternatifs->isEmpty())
    <div class="card fade-in" style="text-align: center; padding: 60px; border-color: rgba(245,158,11,0.3);">
        <div style="font-size: 3rem; margin-bottom: 16px;">⚠️</div>
        <h3 style="font-weight: 700; margin-bottom: 8px;">Data jalur karir belum tersedia</h3>
        <p style="color: var(--text-secondary);">Hubungi admin untuk menambahkan data karir.</p>
    </div>
@else
<form method="POST" action="{{ route('penilaian-kriteria.store') }}" id="penilaianForm">
    @csrf

    @foreach($alternatifs as $alt)
    @php
        $skills = $skillSets[$alt->nama] ?? ['Skill 1', 'Skill 2', 'Skill 3', 'Skill 4'];
        $savedData = $penilaianTersimpan->get($alt->id);
        $savedSkillTeknis = $savedData ? (float)$savedData->skill_teknis : 0;
        $savedMinat = $savedData ? (int)$savedData->minat : 0;
        $savedSertifikat = $savedData ? (int)$savedData->sertifikat : 0;

        // Reconstruct how many skills were selected from saved score
        $totalSkills = count($skills);
        $savedSelectedCount = $savedSkillTeknis > 0 ? round(($savedSkillTeknis / 100) * $totalSkills) : 0;
    @endphp

    <div class="card fade-in" style="margin-bottom: 20px;" id="card-{{ $alt->id }}">
        {{-- Header Karir --}}
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--border);">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 48px; height: 48px; border-radius: 14px; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0;">
                    @php
                        $icons = ['Web Developer'=>'🌐','Mobile Developer'=>'📱','Data Analyst'=>'📊','Network Engineer'=>'🔌','UI/UX Designer'=>'🎨','QA Engineer'=>'🛡️','Data Scientist'=>'⚙️','DevOps Engineer'=>'☁️'];
                    @endphp
                    {{ $icons[$alt->nama] ?? '💼' }}
                </div>
                <div>
                    <h3 style="font-weight: 700; font-size: 1.1rem; margin: 0;">{{ $alt->nama }}</h3>
                    <div style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 2px;">
                        <span id="summary-{{ $alt->id }}-skill" style="color: var(--primary-light);">{{ $savedSelectedCount }}/{{ $totalSkills }} skill</span>
                        &nbsp;·&nbsp;
                        <span>Minat: </span><span id="summary-{{ $alt->id }}-minat" style="color: var(--warning);">{{ $savedMinat > 0 ? str_repeat('⭐', $savedMinat) : '-' }}</span>
                        &nbsp;·&nbsp;
                        <span id="summary-{{ $alt->id }}-sertif" style="color: var(--success);">{{ $savedSertifikat }} sertifikat</span>
                    </div>
                </div>
            </div>
            {{-- Hidden inputs --}}
            <input type="hidden" name="nilai[{{ $alt->id }}][skill_teknis]" id="skill-val-{{ $alt->id }}" value="{{ $savedSkillTeknis }}">
            <input type="hidden" name="nilai[{{ $alt->id }}][minat]" id="minat-val-{{ $alt->id }}" value="{{ $savedMinat }}" required>
            <input type="hidden" name="nilai[{{ $alt->id }}][sertifikat]" id="sertif-val-{{ $alt->id }}" value="{{ $savedSertifikat }}">
        </div>

        <div class="grid-3" style="gap: 24px; align-items: start;">

            {{-- KOLOM 1: Skill Teknis --}}
            <div>
                <div style="font-weight: 600; margin-bottom: 10px; font-size: 0.9rem;">
                    🧠 Skill Teknis
                    <span id="score-{{ $alt->id }}" style="font-size: 0.8rem; color: var(--primary-light); margin-left: 8px;">
                        ({{ round($savedSkillTeknis) }}/100)
                    </span>
                </div>
                <div style="font-size: 0.75rem; color: var(--text-secondary); margin-bottom: 10px;">Pilih skill yang kamu kuasai:</div>
                <div style="display: flex; flex-wrap: wrap; gap: 8px;" id="skills-{{ $alt->id }}">
                    @foreach($skills as $idx => $skill)
                    <button type="button"
                        class="skill-tag"
                        data-alt="{{ $alt->id }}"
                        data-total="{{ $totalSkills }}"
                        onclick="toggleSkill(this)"
                        style="padding: 6px 14px; border-radius: 20px; border: 1px solid var(--border); background: var(--bg-dark); color: var(--text-secondary); font-size: 0.8rem; cursor: pointer; transition: all 0.2s; {{ $idx < $savedSelectedCount ? 'background: rgba(99,102,241,0.2); border-color: var(--primary); color: var(--primary-light);' : '' }}"
                        {{ $idx < $savedSelectedCount ? 'data-selected=true' : '' }}>
                        {{ $skill }}
                    </button>
                    @endforeach
                </div>
                <div style="margin-top: 10px; height: 4px; border-radius: 2px; background: rgba(99,102,241,0.1); overflow: hidden;">
                    <div id="bar-{{ $alt->id }}" style="height: 100%; border-radius: 2px; background: linear-gradient(90deg, var(--primary), var(--accent)); transition: width 0.3s; width: {{ $savedSkillTeknis }}%;"></div>
                </div>
            </div>

            {{-- KOLOM 2: Minat (Star Rating) --}}
            <div>
                <div style="font-weight: 600; margin-bottom: 10px; font-size: 0.9rem;">⭐ Tingkat Minat</div>
                <div style="font-size: 0.75rem; color: var(--text-secondary); margin-bottom: 12px;">Seberapa minat kamu di bidang ini?</div>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    @for($star = 1; $star <= 5; $star++)
                    <button type="button"
                        class="minat-btn"
                        data-alt="{{ $alt->id }}"
                        data-val="{{ $star }}"
                        onclick="selectMinat(this)"
                        style="display: flex; align-items: center; gap: 10px; padding: 8px 14px; border-radius: 10px; border: 1px solid {{ $savedMinat == $star ? 'var(--primary)' : 'var(--border)' }}; background: {{ $savedMinat == $star ? 'rgba(99,102,241,0.15)' : 'var(--bg-dark)' }}; color: {{ $savedMinat == $star ? 'var(--primary-light)' : 'var(--text-secondary)' }}; cursor: pointer; text-align: left; transition: all 0.2s; font-size: 0.82rem; width: 100%;">
                        <span style="font-size: 1rem;">{{ str_repeat('⭐', $star) }}</span>
                        <span>{{ $minatLabels[$star] }}</span>
                    </button>
                    @endfor
                </div>
            </div>

            {{-- KOLOM 3: Sertifikasi (Stepper) --}}
            <div>
                <div style="font-weight: 600; margin-bottom: 10px; font-size: 0.9rem;">
                    📜 Jumlah Sertifikasi
                </div>
                <div style="font-size: 0.75rem; color: var(--text-secondary); margin-bottom: 16px;">
                    Berapa banyak sertifikat relevan yang kamu miliki?
                </div>

                {{-- Stepper --}}
                <div style="display: flex; align-items: center; gap: 0; border: 1px solid var(--border); border-radius: 12px; overflow: hidden; width: fit-content;">
                    <button type="button" onclick="changeSertif({{ $alt->id }}, -1)"
                        style="width: 44px; height: 44px; border: none; background: rgba(239,68,68,0.1); color: var(--danger); font-size: 1.3rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.2s;">−</button>
                    <div style="min-width: 60px; height: 44px; background: var(--bg-dark); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; font-weight: 800; color: var(--primary-light);" id="sertif-display-{{ $alt->id }}">
                        {{ $savedSertifikat }}
                    </div>
                    <button type="button" onclick="changeSertif({{ $alt->id }}, 1)"
                        style="width: 44px; height: 44px; border: none; background: rgba(34,197,94,0.1); color: var(--success); font-size: 1.3rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.2s;">+</button>
                </div>

                {{-- Label jumlah --}}
                <div style="margin-top: 12px; font-size: 0.82rem; color: var(--text-secondary);">
                    @php
                        $labels = ['Belum ada', '1 sertifikat', '2 sertifikat', '3 sertifikat', '4 sertifikat'];
                    @endphp
                    <span id="sertif-label-{{ $alt->id }}">
                        {{ $savedSertifikat <= 4 ? ($labels[$savedSertifikat] ?? $savedSertifikat . ' sertifikat') : $savedSertifikat . ' sertifikat' }}
                    </span>
                </div>

                {{-- Quick select buttons --}}
                <div style="display: flex; flex-wrap: wrap; gap: 6px; margin-top: 14px;">
                    @foreach([0, 1, 2, 3, 5, 10] as $preset)
                    <button type="button" onclick="setSertif({{ $alt->id }}, {{ $preset }})"
                        id="preset-{{ $alt->id }}-{{ $preset }}"
                        style="padding: 4px 12px; border-radius: 20px; border: 1px solid {{ $savedSertifikat == $preset ? 'var(--primary)' : 'var(--border)' }}; background: {{ $savedSertifikat == $preset ? 'rgba(99,102,241,0.15)' : 'var(--bg-dark)' }}; color: {{ $savedSertifikat == $preset ? 'var(--primary-light)' : 'var(--text-secondary)' }}; font-size: 0.78rem; cursor: pointer; transition: all 0.2s;">
                        {{ $preset == 0 ? 'Nol' : $preset }}
                    </button>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
    @endforeach

    {{-- Tombol Submit --}}
    <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 8px;">
        <a href="{{ route('nilai.create') }}" class="btn-secondary">← Kembali ke Nilai</a>
        <button type="submit" class="btn-primary" id="submitBtn">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Simpan Semua Penilaian
        </button>
    </div>
</form>

{{-- Hitung Rekomendasi (jika sudah ada data tersimpan) --}}
@if($penilaianTersimpan->count() > 0)
<div class="card fade-in" style="margin-top: 24px; text-align: center; border-color: var(--success); box-shadow: 0 0 20px rgba(34, 197, 94, 0.1);">
    <div style="font-size: 2.5rem; margin-bottom: 12px;">✨</div>
    <h3 style="font-weight: 700; margin-bottom: 8px;">Semua Data Sudah Terisi!</h3>
    <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 20px;">
        Klik tombol di bawah untuk menghitung rekomendasi karir terbaik untukmu menggunakan metode <strong>AHP + TOPSIS</strong>.
    </p>
    <form action="{{ route('penilaian-kriteria.calculate') }}" method="POST">
        @csrf
        <button type="submit" class="btn-primary" style="background: linear-gradient(135deg, var(--success), #16a34a); padding: 14px 40px; font-size: 1rem;">
            🚀 Hitung Rekomendasi Karir
        </button>
    </form>
</div>
@endif

@endif
@endsection

@section('scripts')
<script>
// Toggle skill button
function toggleSkill(btn) {
    const isSelected = btn.dataset.selected === 'true';
    const altId = btn.dataset.alt;
    const total = parseInt(btn.dataset.total);

    if (isSelected) {
        btn.dataset.selected = 'false';
        btn.style.background = 'var(--bg-dark)';
        btn.style.borderColor = 'var(--border)';
        btn.style.color = 'var(--text-secondary)';
    } else {
        btn.dataset.selected = 'true';
        btn.style.background = 'rgba(99,102,241,0.2)';
        btn.style.borderColor = 'var(--primary)';
        btn.style.color = 'var(--primary-light)';
    }

    // Hitung skor
    const allBtns = document.querySelectorAll(`.skill-tag[data-alt="${altId}"]`);
    let selected = 0;
    allBtns.forEach(b => { if (b.dataset.selected === 'true') selected++; });

    const score = total > 0 ? Math.round((selected / total) * 100) : 0;
    document.getElementById(`skill-val-${altId}`).value = score;
    document.getElementById(`score-${altId}`).textContent = `(${score}/100)`;
    document.getElementById(`bar-${altId}`).style.width = score + '%';
    document.getElementById(`summary-${altId}-skill`).textContent = `${selected}/${total} skill`;
}

// Select minat (star rating)
function selectMinat(btn) {
    const altId = btn.dataset.alt;
    const val = btn.dataset.val;

    // Reset all
    document.querySelectorAll(`.minat-btn[data-alt="${altId}"]`).forEach(b => {
        b.style.background = 'var(--bg-dark)';
        b.style.borderColor = 'var(--border)';
        b.style.color = 'var(--text-secondary)';
    });

    // Highlight selected
    btn.style.background = 'rgba(99,102,241,0.15)';
    btn.style.borderColor = 'var(--primary)';
    btn.style.color = 'var(--primary-light)';

    document.getElementById(`minat-val-${altId}`).value = val;
    document.getElementById(`summary-${altId}-minat`).textContent = '⭐'.repeat(parseInt(val));
}

// Stepper sertifikasi: ubah nilai +/−
function changeSertif(altId, delta) {
    const input = document.getElementById(`sertif-val-${altId}`);
    let val = Math.max(0, parseInt(input.value || 0) + delta);
    setSertif(altId, val);
}

// Set nilai sertifikasi langsung (preset / stepper)
function setSertif(altId, val) {
    val = Math.max(0, val);
    document.getElementById(`sertif-val-${altId}`).value = val;
    document.getElementById(`sertif-display-${altId}`).textContent = val;

    // Label teks
    const labels = ['Belum ada', '1 sertifikat', '2 sertifikat', '3 sertifikat', '4 sertifikat'];
    const labelText = val <= 4 ? (labels[val] || val + ' sertifikat') : val + ' sertifikat';
    document.getElementById(`sertif-label-${altId}`).textContent = labelText;

    // Update summary header
    document.getElementById(`summary-${altId}-sertif`).textContent = val + ' sertifikat';

    // Update preset buttons highlight
    [0, 1, 2, 3, 5, 10].forEach(p => {
        const btn = document.getElementById(`preset-${altId}-${p}`);
        if (!btn) return;
        if (p === val) {
            btn.style.background = 'rgba(99,102,241,0.15)';
            btn.style.borderColor = 'var(--primary)';
            btn.style.color = 'var(--primary-light)';
        } else {
            btn.style.background = 'var(--bg-dark)';
            btn.style.borderColor = 'var(--border)';
            btn.style.color = 'var(--text-secondary)';
        }
    });
}

// Validasi sebelum submit
document.getElementById('penilaianForm')?.addEventListener('submit', function(e) {
    const minatInputs = document.querySelectorAll('[id^="minat-val-"]');
    let allFilled = true;
    minatInputs.forEach(inp => {
        if (!inp.value || inp.value == 0) {
            allFilled = false;
            const altId = inp.id.replace('minat-val-', '');
            document.getElementById(`card-${altId}`).scrollIntoView({ behavior: 'smooth' });
        }
    });

    if (!allFilled) {
        e.preventDefault();
        alert('Pastikan semua tingkat minat (⭐) sudah dipilih untuk setiap jalur karir!');
    }
});
</script>
@endsection
