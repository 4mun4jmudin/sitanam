<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-3">
                <div
                    class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-800 ring-2 ring-slate-950 shadow-sm">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>

                <div>
                    <h2 class="text-2xl font-black tracking-tight text-slate-950">
                        Dokumentasi Halaman Guru
                    </h2>
                    <p class="mt-1 text-sm font-semibold text-slate-700">
                        Panduan alur sistem, konsep perhitungan, dan Rule-Based Decision Tree untuk evaluasi panen.
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('guru.evaluasi.index') }}"
                    class="inline-flex items-center gap-2 rounded-2xl border-2 border-slate-950 bg-emerald-600 px-4 py-2.5 text-sm font-black text-white shadow-md shadow-emerald-700/25 transition hover:bg-emerald-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-6a2 2 0 012-2h8m0 0l-4-4m4 4l-4 4M5 7v10a2 2 0 002 2h4" />
                    </svg>
                    Buka Evaluasi Panen
                </a>

                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center gap-2 rounded-2xl border-2 border-slate-950 bg-slate-100 px-4 py-2.5 text-sm font-black text-slate-950 shadow-sm transition hover:bg-slate-200">
                    Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <style>
        [x-cloak] {
            display: none !important;
        }

        .doc-page {
            color: #0f172a;
        }

        .doc-page * {
            box-sizing: border-box;
        }

        .doc-section {
            scroll-margin-top: 190px;
        }

        .doc-card {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border: 2px solid #020617;
            color: #020617;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.10);
        }

        .doc-card h1,
        .doc-card h2,
        .doc-card h3,
        .doc-card h4,
        .doc-card p,
        .doc-card li,
        .doc-card span {
            color: #020617;
        }

        .doc-panel {
            background: linear-gradient(135deg, #f1f5f9 0%, #ecfdf5 100%);
            border: 2px solid #020617;
            color: #020617;
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.10);
        }

        .doc-green {
            background: linear-gradient(135deg, #bbf7d0 0%, #dcfce7 100%);
            border: 2px solid #14532d;
            color: #052e16;
            box-shadow: 0 10px 24px rgba(20, 83, 45, 0.12);
        }

        .doc-blue {
            background: linear-gradient(135deg, #bfdbfe 0%, #dbeafe 100%);
            border: 2px solid #1e3a8a;
            color: #172554;
            box-shadow: 0 10px 24px rgba(30, 58, 138, 0.12);
        }

        .doc-yellow {
            background: linear-gradient(135deg, #fde68a 0%, #fef3c7 100%);
            border: 2px solid #92400e;
            color: #451a03;
            box-shadow: 0 10px 24px rgba(146, 64, 14, 0.12);
        }

        .doc-red {
            background: linear-gradient(135deg, #fecaca 0%, #fee2e2 100%);
            border: 2px solid #991b1b;
            color: #450a0a;
            box-shadow: 0 10px 24px rgba(153, 27, 27, 0.12);
        }

        .doc-purple {
            background: linear-gradient(135deg, #ddd6fe 0%, #ede9fe 100%);
            border: 2px solid #4c1d95;
            color: #2e1065;
            box-shadow: 0 10px 24px rgba(76, 29, 149, 0.12);
        }

        .doc-dark {
            background: linear-gradient(135deg, #020617 0%, #064e3b 55%, #065f46 100%);
            border: 2px solid #020617;
            color: #ffffff;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.28);
        }

        .doc-dark h1,
        .doc-dark h2,
        .doc-dark h3,
        .doc-dark h4,
        .doc-dark p,
        .doc-dark li,
        .doc-dark span {
            color: #ffffff;
        }

        .doc-code {
            background: #020617;
            border: 2px solid #020617;
            color: #d1fae5;
            box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.45);
        }

        .doc-floating-tabs {
            position: sticky;
            top: 62px;
            z-index: 45;
            background: rgba(241, 245, 249, 0.92);
            backdrop-filter: blur(14px);
            border: 2px solid #020617;
            border-radius: 9999px;
            padding: 6px 8px;
            margin-bottom: 22px;
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.14);
        }

        .doc-tab-scroll {
            display: flex;
            gap: 6px;
            overflow-x: auto;
            scroll-behavior: smooth;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .doc-tab-scroll::-webkit-scrollbar {
            display: none;
        }

        .doc-tab-btn {
            border: 2px solid #020617;
            background: #f8fafc;
            color: #020617;
            font-weight: 900;
        }

        .doc-tab-btn:hover {
            background: #bbf7d0;
            color: #052e16;
        }

        .doc-tab-active {
            border: 2px solid #020617;
            background: #047857;
            color: #ffffff;
            font-weight: 900;
            box-shadow: 0 6px 14px rgba(4, 120, 87, 0.28);
        }

        @media (max-width: 768px) {
            .doc-floating-tabs {
                top: 56px;
                border-radius: 18px;
            }
        }

        @media (max-width: 768px) {
            .doc-floating-tabs {
                top: 78px;
            }

            .doc-section {
                scroll-margin-top: 170px;
            }
        }

        .doc-tab-btn {
            border: 2px solid #020617;
            background: #f1f5f9;
            color: #020617;
            font-weight: 900;
        }

        .doc-tab-btn:hover {
            background: #bbf7d0;
            color: #052e16;
        }

        .doc-tab-active {
            border: 2px solid #020617;
            background: #047857;
            color: #ffffff;
            font-weight: 900;
            box-shadow: 0 8px 18px rgba(4, 120, 87, 0.25);
        }

        .doc-table th {
            background: #020617;
            color: #ffffff;
            border-bottom: 2px solid #020617;
        }

        .doc-table td {
            border-bottom: 1px solid #cbd5e1;
            color: #020617;
            font-weight: 700;
        }

        .doc-table tbody tr:nth-child(odd) {
            background: #f8fafc;
        }

        .doc-table tbody tr:nth-child(even) {
            background: #e2e8f0;
        }
    </style>

    <div x-data="{
            activeSection: 'overview',
            openFaq: 1,

            scrollToSection(id) {
                this.activeSection = id;

                const el = document.getElementById(id);

                if (el) {
                    const y = el.getBoundingClientRect().top + window.pageYOffset - 175;
                    window.scrollTo({
                        top: y,
                        behavior: 'smooth'
                    });
                }
            },

            tabClass(id) {
                return this.activeSection === id ? 'doc-tab-active' : 'doc-tab-btn';
            }
        }" class="doc-page mx-auto max-w-7xl px-4 pb-16 pt-6 sm:px-6 lg:px-8">

        {{-- FLOATING MINI TAB BAR --}}
        <div class="doc-floating-tabs">
            <div class="doc-tab-scroll">
                <button type="button" @click="scrollToSection('overview')" :class="tabClass('overview')"
                    class="shrink-0 rounded-full px-3 py-1.5 text-[11px] leading-none transition">
                    Ringkasan
                </button>

                <button type="button" @click="scrollToSection('purpose')" :class="tabClass('purpose')"
                    class="shrink-0 rounded-full px-3 py-1.5 text-[11px] leading-none transition">
                    Tujuan
                </button>

                <button type="button" @click="scrollToSection('roles')" :class="tabClass('roles')"
                    class="shrink-0 rounded-full px-3 py-1.5 text-[11px] leading-none transition">
                    Role
                </button>

                <button type="button" @click="scrollToSection('teacher-menu')" :class="tabClass('teacher-menu')"
                    class="shrink-0 rounded-full px-3 py-1.5 text-[11px] leading-none transition">
                    Menu
                </button>

                <button type="button" @click="scrollToSection('flow')" :class="tabClass('flow')"
                    class="shrink-0 rounded-full px-3 py-1.5 text-[11px] leading-none transition">
                    Alur
                </button>

                <button type="button" @click="scrollToSection('input-data')" :class="tabClass('input-data')"
                    class="shrink-0 rounded-full px-3 py-1.5 text-[11px] leading-none transition">
                    Input
                </button>

                <button type="button" @click="scrollToSection('checklist')" :class="tabClass('checklist')"
                    class="shrink-0 rounded-full px-3 py-1.5 text-[11px] leading-none transition">
                    Checklist
                </button>

                <button type="button" @click="scrollToSection('calculation')" :class="tabClass('calculation')"
                    class="shrink-0 rounded-full px-3 py-1.5 text-[11px] leading-none transition">
                    Rumus
                </button>

                <button type="button" @click="scrollToSection('rules')" :class="tabClass('rules')"
                    class="shrink-0 rounded-full px-3 py-1.5 text-[11px] leading-none transition">
                    Rules
                </button>

                <button type="button" @click="scrollToSection('score')" :class="tabClass('score')"
                    class="shrink-0 rounded-full px-3 py-1.5 text-[11px] leading-none transition">
                    Skor
                </button>

                <button type="button" @click="scrollToSection('output')" :class="tabClass('output')"
                    class="shrink-0 rounded-full px-3 py-1.5 text-[11px] leading-none transition">
                    Output
                </button>

                <button type="button" @click="scrollToSection('fivewoneh')" :class="tabClass('fivewoneh')"
                    class="shrink-0 rounded-full px-3 py-1.5 text-[11px] leading-none transition">
                    5W+1H
                </button>

                <button type="button" @click="scrollToSection('faq')" :class="tabClass('faq')"
                    class="shrink-0 rounded-full px-3 py-1.5 text-[11px] leading-none transition">
                    FAQ
                </button>

                <button type="button" @click="scrollToSection('test-case')" :class="tabClass('test-case')"
                    class="shrink-0 rounded-full px-3 py-1.5 text-[11px] leading-none transition">
                    Uji
                </button>
            </div>
        </div>

        {{-- HERO --}}
        <section id="overview" class="doc-section doc-dark relative overflow-hidden rounded-[2rem] p-6 sm:p-8 lg:p-10">
            <div class="absolute -right-20 -top-24 h-80 w-80 rounded-full bg-emerald-300/20 blur-3xl"></div>
            <div class="absolute -bottom-28 left-20 h-72 w-72 rounded-full bg-white/10 blur-3xl"></div>

            <div class="relative z-10 grid gap-8 lg:grid-cols-[1.4fr_0.6fr] lg:items-center">
                <div>
                    <div
                        class="mb-5 inline-flex items-center gap-2 rounded-full border-2 border-white/40 bg-white/10 px-4 py-2 text-xs font-extrabold uppercase tracking-[0.18em] text-emerald-100 backdrop-blur">
                        <span class="h-2 w-2 rounded-full bg-emerald-300"></span>
                        Panduan Guru Pembimbing
                    </div>

                    <h1 class="max-w-4xl text-3xl font-black leading-tight tracking-tight sm:text-4xl lg:text-5xl">
                        Evaluasi Keberhasilan Panen Menggunakan
                        <span class="text-emerald-200">Rule-Based Decision Tree</span>
                    </h1>

                    <p class="mt-5 max-w-3xl text-sm font-semibold leading-7 text-emerald-50 sm:text-base">
                        Dokumentasi ini menjelaskan bagaimana guru menggunakan sistem Si Tanam/HawariFarm untuk memantau
                        data penanaman, pemeliharaan, panen, dan memproses evaluasi hasil panen menjadi kategori
                        <strong>Berhasil</strong>, <strong>Cukup</strong>, atau <strong>Gagal</strong>.
                    </p>

                    <div class="mt-7 flex flex-wrap gap-3">
                        <button type="button" @click="scrollToSection('flow')"
                            class="inline-flex items-center gap-2 rounded-2xl border-2 border-slate-950 bg-emerald-200 px-5 py-3 text-sm font-black text-emerald-950 shadow-lg shadow-slate-950/20 transition hover:bg-emerald-300">
                            Lihat Alur Sistem
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </button>

                        <button type="button" @click="scrollToSection('rules')"
                            class="inline-flex items-center gap-2 rounded-2xl border-2 border-emerald-200 bg-white/10 px-5 py-3 text-sm font-black text-white backdrop-blur transition hover:bg-white/20">
                            Aturan Decision Tree
                        </button>
                    </div>
                </div>

                <div class="rounded-[1.7rem] border-2 border-white/30 bg-white/10 p-5 shadow-xl backdrop-blur">
                    <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-emerald-100">
                        Fokus Sistem
                    </p>

                    <div class="mt-5 space-y-4">
                        <div
                            class="rounded-2xl border-2 border-emerald-200 bg-gradient-to-br from-emerald-700 to-emerald-950 p-4 shadow-lg shadow-emerald-950/30">
                            <p class="!text-sm !font-black !text-emerald-100">
                                Role pemroses evaluasi
                            </p>
                            <p class="mt-1 !text-2xl !font-black !text-white">
                                Guru
                            </p>
                        </div>

                        <div
                            class="rounded-2xl border-2 border-blue-200 bg-gradient-to-br from-blue-700 to-blue-950 p-4 shadow-lg shadow-blue-950/30">
                            <p class="!text-sm !font-black !text-blue-100">
                                Modul utama algoritma
                            </p>
                            <p class="mt-1 !text-2xl !font-black !text-white">
                                Evaluasi Panen
                            </p>
                        </div>

                        <div
                            class="rounded-2xl border-2 border-purple-200 bg-gradient-to-br from-purple-700 to-purple-950 p-4 shadow-lg shadow-purple-950/30">
                            <p class="!text-sm !font-black !text-purple-100">
                                Output sistem
                            </p>
                            <p class="mt-1 !text-2xl !font-black !text-white">
                                Berhasil / Cukup / Gagal
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- QUICK SUMMARY --}}
        <section class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="doc-green rounded-3xl p-5">
                <div
                    class="flex h-11 w-11 items-center justify-center rounded-2xl border-2 border-slate-950 bg-emerald-700 text-white shadow-sm">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V6m0 12v-2" />
                    </svg>
                </div>
                <h3 class="mt-4 text-sm font-black uppercase tracking-wide">Apa Sistem Ini?</h3>
                <p class="mt-2 text-sm font-black leading-6">
                    Sistem pendataan praktik pertanian siswa dari tanam sampai panen.
                </p>
            </div>

            <div class="doc-blue rounded-3xl p-5">
                <div
                    class="flex h-11 w-11 items-center justify-center rounded-2xl border-2 border-slate-950 bg-blue-700 text-white shadow-sm">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 9l3 3-3 3m5 0h3M5 5h14v14H5z" />
                    </svg>
                </div>
                <h3 class="mt-4 text-sm font-black uppercase tracking-wide">Bagaimana Menilai?</h3>
                <p class="mt-2 text-sm font-black leading-6">
                    Sistem menghitung persentase hidup, persentase hasil, hama, dan daun.
                </p>
            </div>

            <div class="doc-yellow rounded-3xl p-5">
                <div
                    class="flex h-11 w-11 items-center justify-center rounded-2xl border-2 border-slate-950 bg-amber-600 text-white shadow-sm">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19V6l12-2v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-2c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z" />
                    </svg>
                </div>
                <h3 class="mt-4 text-sm font-black uppercase tracking-wide">Siapa Memproses?</h3>
                <p class="mt-2 text-sm font-black leading-6">
                    Guru memproses evaluasi. Siswa hanya menginput data dan melihat hasil.
                </p>
            </div>

            <div class="doc-purple rounded-3xl p-5">
                <div
                    class="flex h-11 w-11 items-center justify-center rounded-2xl border-2 border-slate-950 bg-purple-700 text-white shadow-sm">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                    </svg>
                </div>
                <h3 class="mt-4 text-sm font-black uppercase tracking-wide">Apa Outputnya?</h3>
                <p class="mt-2 text-sm font-black leading-6">
                    Klasifikasi, skor, faktor utama, rekomendasi, dan rincian aturan.
                </p>
            </div>
        </section>

        <div class="mt-8 grid gap-8 lg:grid-cols-[280px_1fr]">
            {{-- SIDEBAR TOC --}}
            <aside class="hidden lg:block">
                <div
                    class="sticky top-[205px] rounded-3xl border-2 border-slate-950 bg-slate-200 p-5 shadow-xl shadow-slate-400/40">
                    <div class="mb-4">
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-emerald-900">
                            Daftar Isi
                        </p>
                        <h3 class="mt-1 text-lg font-black text-slate-950">
                            Navigasi Detail
                        </h3>
                    </div>

                    <nav class="space-y-1 text-sm font-black">
                        <button type="button" @click="scrollToSection('overview')"
                            class="block w-full rounded-xl px-3 py-2 text-left text-slate-950 transition hover:bg-emerald-200">
                            1. Ringkasan
                        </button>
                        <button type="button" @click="scrollToSection('purpose')"
                            class="block w-full rounded-xl px-3 py-2 text-left text-slate-950 transition hover:bg-emerald-200">
                            2. Maksud & Tujuan
                        </button>
                        <button type="button" @click="scrollToSection('roles')"
                            class="block w-full rounded-xl px-3 py-2 text-left text-slate-950 transition hover:bg-emerald-200">
                            3. Role Pengguna
                        </button>
                        <button type="button" @click="scrollToSection('teacher-menu')"
                            class="block w-full rounded-xl px-3 py-2 text-left text-slate-950 transition hover:bg-emerald-200">
                            4. Menu Guru
                        </button>
                        <button type="button" @click="scrollToSection('flow')"
                            class="block w-full rounded-xl px-3 py-2 text-left text-slate-950 transition hover:bg-emerald-200">
                            5. Alur Sistem
                        </button>
                        <button type="button" @click="scrollToSection('input-data')"
                            class="block w-full rounded-xl px-3 py-2 text-left text-slate-950 transition hover:bg-emerald-200">
                            6. Data Input
                        </button>
                        <button type="button" @click="scrollToSection('checklist')"
                            class="block w-full rounded-xl px-3 py-2 text-left text-slate-950 transition hover:bg-emerald-200">
                            7. Checklist
                        </button>
                        <button type="button" @click="scrollToSection('calculation')"
                            class="block w-full rounded-xl px-3 py-2 text-left text-slate-950 transition hover:bg-emerald-200">
                            8. Perhitungan
                        </button>
                        <button type="button" @click="scrollToSection('rules')"
                            class="block w-full rounded-xl px-3 py-2 text-left text-slate-950 transition hover:bg-emerald-200">
                            9. Aturan Tree
                        </button>
                        <button type="button" @click="scrollToSection('score')"
                            class="block w-full rounded-xl px-3 py-2 text-left text-slate-950 transition hover:bg-emerald-200">
                            10. Skor
                        </button>
                        <button type="button" @click="scrollToSection('output')"
                            class="block w-full rounded-xl px-3 py-2 text-left text-slate-950 transition hover:bg-emerald-200">
                            11. Output
                        </button>
                        <button type="button" @click="scrollToSection('fivewoneh')"
                            class="block w-full rounded-xl px-3 py-2 text-left text-slate-950 transition hover:bg-emerald-200">
                            12. 5W+1H
                        </button>
                        <button type="button" @click="scrollToSection('faq')"
                            class="block w-full rounded-xl px-3 py-2 text-left text-slate-950 transition hover:bg-emerald-200">
                            13. FAQ
                        </button>
                        <button type="button" @click="scrollToSection('test-case')"
                            class="block w-full rounded-xl px-3 py-2 text-left text-slate-950 transition hover:bg-emerald-200">
                            14. Kasus Uji
                        </button>
                    </nav>
                </div>
            </aside>

            {{-- CONTENT --}}
            <main class="space-y-8">
                {{-- PURPOSE --}}
                <section id="purpose" class="doc-section doc-panel rounded-[2rem] p-6 sm:p-8">
                    <div class="mb-6 flex items-start gap-4">
                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl border-2 border-slate-950 bg-emerald-700 text-white shadow-sm">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M12 18a6 6 0 100-12 6 6 0 000 12z" />
                            </svg>
                        </div>

                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.18em] text-emerald-900">
                                Konsep Dasar
                            </p>
                            <h2 class="mt-1 text-2xl font-black text-slate-950">
                                Maksud dan Tujuan Sistem
                            </h2>
                            <p class="mt-2 text-sm font-black leading-7 text-slate-800">
                                Sistem dibuat agar proses pendataan praktik pertanian dan evaluasi panen siswa lebih
                                rapi, terukur, dan mudah dijelaskan.
                            </p>
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="doc-card rounded-3xl p-5">
                            <h3 class="text-base font-black">Maksud</h3>
                            <p class="mt-3 text-sm font-bold leading-7">
                                Mendata kegiatan praktik pertanian dari tahap penanaman, pemeliharaan, hingga panen,
                                lalu menggunakan data tersebut sebagai dasar evaluasi keberhasilan panen.
                            </p>
                        </div>

                        <div class="doc-green rounded-3xl p-5">
                            <h3 class="text-base font-black">Tujuan</h3>
                            <ul class="mt-3 space-y-2 text-sm font-black leading-6">
                                <li class="flex gap-2"><span>•</span> Membantu guru memantau proyek tanam siswa.</li>
                                <li class="flex gap-2"><span>•</span> Menilai hasil panen secara lebih objektif.</li>
                                <li class="flex gap-2"><span>•</span> Memberi skor, faktor utama, rekomendasi, dan
                                    rincian aturan.</li>
                            </ul>
                        </div>
                    </div>
                </section>

                {{-- ROLES --}}
                <section id="roles" class="doc-section doc-panel rounded-[2rem] p-6 sm:p-8">
                    <div class="mb-6">
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-emerald-900">
                            Hak Akses
                        </p>
                        <h2 class="mt-1 text-2xl font-black text-slate-950">
                            Konsep Role pada Sistem
                        </h2>
                    </div>

                    <div class="grid gap-4 md:grid-cols-3">
                        <div class="doc-blue rounded-3xl p-5">
                            <div
                                class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl border-2 border-slate-950 bg-blue-700 text-white shadow-sm">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 14l9-5-9-5-9 5 9 5zm0 0v7" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-black">Siswa</h3>
                            <p class="mt-2 text-sm font-black leading-7">
                                Menginput data penanaman, pemeliharaan, dan panen. Siswa hanya melihat hasil evaluasi,
                                tidak memproses Decision Tree.
                            </p>
                        </div>

                        <div class="doc-green rounded-3xl p-5">
                            <div
                                class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl border-2 border-slate-950 bg-emerald-700 text-white shadow-sm">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-6a2 2 0 012-2h6M9 17H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v2" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-black">Guru</h3>
                            <p class="mt-2 text-sm font-black leading-7">
                                Mengecek kelengkapan data, memproses evaluasi panen, melihat hasil klasifikasi, skor,
                                faktor, rekomendasi, dan jalur aturan.
                            </p>
                        </div>

                        <div class="doc-card rounded-3xl p-5">
                            <div
                                class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl border-2 border-slate-950 bg-slate-900 text-white shadow-sm">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5.121 17.804A9 9 0 1118.88 6.196M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-black">Admin</h3>
                            <p class="mt-2 text-sm font-bold leading-7">
                                Mengelola akun pengguna dan profil. Admin tidak difokuskan memproses evaluasi agar tetap
                                sesuai use case.
                            </p>
                        </div>
                    </div>
                </section>

                {{-- MENU --}}
                <section id="teacher-menu" class="doc-section doc-panel rounded-[2rem] p-6 sm:p-8">
                    <div class="mb-6">
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-emerald-900">
                            Modul Guru
                        </p>
                        <h2 class="mt-1 text-2xl font-black text-slate-950">
                            Menu yang Digunakan Guru
                        </h2>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        @php
                            $menus = [
                                ['title' => 'Dashboard', 'desc' => 'Melihat ringkasan jumlah siswa, proyek aktif, laporan panen, dan total evaluasi.'],
                                ['title' => 'Rekap Penanaman', 'desc' => 'Melihat data awal proyek tanam seperti jumlah bibit, target panen, lokasi, dan tanggal tanam.'],
                                ['title' => 'Pemeliharaan', 'desc' => 'Melihat riwayat kondisi daun, tingkat hama, tinggi tanaman, kegiatan, dan jumlah hidup/mati.'],
                                ['title' => 'Catat Panen', 'desc' => 'Melihat data hasil panen akhir seperti bobot panen, tanggal panen, tanaman hidup, dan tanaman mati.'],
                                ['title' => 'Evaluasi Panen', 'desc' => 'Pusat proses Decision Tree untuk menentukan Berhasil, Cukup, atau Gagal.'],
                            ];
                        @endphp

                        @foreach($menus as $index => $menu)
                            <div class="doc-card rounded-3xl p-5 transition hover:scale-[1.01]">
                                <div class="flex gap-4">
                                    <div
                                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl border-2 border-slate-950 bg-emerald-700 text-sm font-black text-white shadow-sm">
                                        {{ $index + 1 }}
                                    </div>
                                    <div>
                                        <h3 class="font-black">{{ $menu['title'] }}</h3>
                                        <p class="mt-1 text-sm font-bold leading-6">{{ $menu['desc'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                {{-- FLOW --}}
                <section id="flow" class="doc-section doc-panel rounded-[2rem] p-6 sm:p-8">
                    <div class="mb-6">
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-emerald-900">
                            Alur Sistem
                        </p>
                        <h2 class="mt-1 text-2xl font-black text-slate-950">
                            Tahapan dari Input sampai Evaluasi
                        </h2>
                    </div>

                    <div class="relative">
                        <div
                            class="absolute left-6 top-8 hidden h-[calc(100%-4rem)] w-1 rounded-full bg-emerald-700 md:block">
                        </div>

                        <div class="space-y-4">
                            @php
                                $flows = [
                                    ['title' => 'Siswa Input Penanaman', 'desc' => 'Data jumlah bibit dan target panen menjadi dasar perhitungan Decision Tree.'],
                                    ['title' => 'Siswa Input Pemeliharaan', 'desc' => 'Kondisi daun, tingkat hama, tinggi tanaman, dan tanaman mati/hidup dicatat secara berkala.'],
                                    ['title' => 'Siswa Input Panen', 'desc' => 'Bobot panen, tanggal panen, tanaman hidup, dan tanaman mati dicatat sebagai data akhir.'],
                                    ['title' => 'Guru Cek Checklist', 'desc' => 'Sistem memastikan seluruh data penting sudah lengkap dan valid sebelum evaluasi diproses.'],
                                    ['title' => 'Guru Proses Evaluasi', 'desc' => 'Sistem menjalankan Rule-Based Decision Tree dan menyimpan hasil klasifikasi.'],
                                ];
                            @endphp

                            @foreach($flows as $index => $flow)
                                <div class="doc-card relative flex gap-4 rounded-3xl p-5 md:ml-2">
                                    <div
                                        class="z-10 flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl border-2 border-slate-950 bg-emerald-700 text-lg font-black text-white shadow-sm">
                                        {{ $index + 1 }}
                                    </div>
                                    <div>
                                        <h3 class="text-base font-black">{{ $flow['title'] }}</h3>
                                        <p class="mt-1 text-sm font-bold leading-7">{{ $flow['desc'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>

                {{-- INPUT DATA --}}
                <section id="input-data" class="doc-section doc-panel rounded-[2rem] p-6 sm:p-8">
                    <div class="mb-6">
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-emerald-900">
                            Data Input
                        </p>
                        <h2 class="mt-1 text-2xl font-black text-slate-950">
                            Data yang Dipakai Decision Tree
                        </h2>
                    </div>

                    <div class="grid gap-4 lg:grid-cols-3">
                        <div class="doc-green rounded-3xl p-5">
                            <h3 class="font-black">Data Penanaman</h3>
                            <ul class="mt-4 space-y-2 text-sm font-black">
                                <li>• Jenis tanaman</li>
                                <li>• Jumlah bibit</li>
                                <li>• Target panen kg</li>
                                <li>• Tanggal tanam</li>
                                <li>• Kondisi tanah</li>
                            </ul>
                        </div>

                        <div class="doc-blue rounded-3xl p-5">
                            <h3 class="font-black">Data Pemeliharaan</h3>
                            <ul class="mt-4 space-y-2 text-sm font-black">
                                <li>• Tinggi tanaman</li>
                                <li>• Jumlah hidup</li>
                                <li>• Jumlah mati</li>
                                <li>• Kondisi daun</li>
                                <li>• Tingkat hama</li>
                            </ul>
                        </div>

                        <div class="doc-yellow rounded-3xl p-5">
                            <h3 class="font-black">Data Panen</h3>
                            <ul class="mt-4 space-y-2 text-sm font-black">
                                <li>• Tanggal panen</li>
                                <li>• Bobot panen</li>
                                <li>• Tanaman hidup</li>
                                <li>• Tanaman mati</li>
                                <li>• Perbandingan dengan target</li>
                            </ul>
                        </div>
                    </div>
                </section>

                {{-- CHECKLIST --}}
                <section id="checklist" class="doc-section doc-green rounded-[2rem] p-6 sm:p-8">
                    <div class="mb-6">
                        <p class="text-xs font-black uppercase tracking-[0.18em]">
                            Validasi Sistem
                        </p>
                        <h2 class="mt-1 text-2xl font-black">
                            Checklist Kesiapan Evaluasi
                        </h2>
                        <p class="mt-2 text-sm font-black leading-7">
                            Tombol <strong>Proses Evaluasi Panen</strong> hanya aktif jika seluruh checklist terpenuhi.
                        </p>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2">
                        @php
                            $checks = [
                                'Data penanaman tersedia',
                                'Jumlah bibit lebih dari 0',
                                'Target panen lebih dari 0',
                                'Minimal 1 data pemeliharaan',
                                'Kondisi daun tersedia',
                                'Tingkat hama tersedia',
                                'Data panen tersedia',
                                'Bobot panen tersedia',
                                'Tanaman hidup + mati tidak melebihi bibit awal',
                            ];
                        @endphp

                        @foreach($checks as $check)
                            <div class="doc-card flex items-start gap-3 rounded-2xl p-4">
                                <div
                                    class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-slate-950 bg-emerald-700 text-white">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <p class="text-sm font-black leading-6">{{ $check }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>

                {{-- CALCULATION --}}
                <section id="calculation" class="doc-section doc-panel rounded-[2rem] p-6 sm:p-8">
                    <div class="mb-6">
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-emerald-900">
                            Perhitungan
                        </p>
                        <h2 class="mt-1 text-2xl font-black text-slate-950">
                            Konsep Ekstraksi Fitur
                        </h2>
                    </div>

                    <div class="grid gap-5 lg:grid-cols-2">
                        <div class="doc-dark rounded-3xl p-6">
                            <p class="text-xs font-black uppercase tracking-[0.18em] text-emerald-200">
                                Rumus 1
                            </p>
                            <h3 class="mt-2 text-xl font-black">
                                Persentase Tanaman Hidup
                            </h3>
                            <div class="doc-code mt-5 rounded-2xl p-4 font-mono text-sm font-black">
                                persentase_hidup = tanaman_hidup / jumlah_bibit × 100
                            </div>
                            <p class="mt-4 text-sm font-bold leading-7">
                                Dipakai untuk mengetahui berapa persen tanaman yang berhasil bertahan sampai panen.
                            </p>
                        </div>

                        <div class="doc-dark rounded-3xl p-6">
                            <p class="text-xs font-black uppercase tracking-[0.18em] text-blue-200">
                                Rumus 2
                            </p>
                            <h3 class="mt-2 text-xl font-black">
                                Persentase Hasil Panen
                            </h3>
                            <div class="doc-code mt-5 rounded-2xl p-4 font-mono text-sm font-black">
                                persentase_hasil = bobot_panen / target_panen × 100
                            </div>
                            <p class="mt-4 text-sm font-bold leading-7">
                                Dipakai untuk mengetahui sejauh mana hasil panen mencapai target yang ditentukan.
                            </p>
                        </div>
                    </div>
                </section>

                {{-- RULES --}}
                <section id="rules" class="doc-section doc-panel rounded-[2rem] p-6 sm:p-8">
                    <div class="mb-6">
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-emerald-900">
                            Algoritma
                        </p>
                        <h2 class="mt-1 text-2xl font-black text-slate-950">
                            Aturan Rule-Based Decision Tree
                        </h2>
                        <p class="mt-2 text-sm font-black leading-7 text-slate-800">
                            Sistem memakai aturan bercabang untuk menentukan kategori akhir panen.
                        </p>
                    </div>

                    <div class="space-y-5">
                        <div class="doc-red overflow-hidden rounded-3xl">
                            <div class="border-b-2 border-red-950 bg-red-700 px-5 py-4">
                                <h3 class="text-lg font-black text-white">Node 1 — Gagal</h3>
                            </div>
                            <div class="p-5">
                                <pre class="doc-card overflow-x-auto rounded-2xl p-4 text-sm font-black leading-7"><code>IF persentase_hidup &lt; 50
OR persentase_hasil &lt; 50
OR tingkat_hama = Berat
OR kondisi_daun = Layu dan hasil rendah
THEN hasil = Gagal</code></pre>
                            </div>
                        </div>

                        <div class="doc-green overflow-hidden rounded-3xl">
                            <div class="border-b-2 border-emerald-950 bg-emerald-700 px-5 py-4">
                                <h3 class="text-lg font-black text-white">Node 2 — Berhasil</h3>
                            </div>
                            <div class="p-5">
                                <pre class="doc-card overflow-x-auto rounded-2xl p-4 text-sm font-black leading-7"><code>IF persentase_hidup &gt;= 80
AND persentase_hasil &gt;= 80
AND tingkat_hama bukan Berat
AND kondisi_daun bukan Layu
THEN hasil = Berhasil</code></pre>
                            </div>
                        </div>

                        <div class="doc-yellow overflow-hidden rounded-3xl">
                            <div class="border-b-2 border-amber-950 bg-amber-600 px-5 py-4">
                                <h3 class="text-lg font-black text-white">Node 3 — Cukup</h3>
                            </div>
                            <div class="p-5">
                                <pre class="doc-card overflow-x-auto rounded-2xl p-4 text-sm font-black leading-7"><code>IF tidak masuk Gagal
AND tidak memenuhi Berhasil
THEN hasil = Cukup</code></pre>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- SCORE --}}
                <section id="score" class="doc-section doc-dark overflow-hidden rounded-[2rem] p-6 sm:p-8">
                    <div class="mb-6">
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-emerald-200">
                            Skoring
                        </p>
                        <h2 class="mt-1 text-2xl font-black">
                            Perhitungan Skor Evaluasi
                        </h2>
                        <p class="mt-2 text-sm font-bold leading-7">
                            Selain klasifikasi, sistem menampilkan skor numerik 0 sampai 100.
                        </p>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <div
                            class="rounded-3xl border-2 border-emerald-200 bg-gradient-to-br from-emerald-700 to-emerald-950 p-5 shadow-lg shadow-emerald-950/30">
                            <div
                                class="mb-4 flex h-11 w-11 items-center justify-center rounded-2xl border-2 border-white/40 bg-white/15 text-white">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>

                            <p class="!text-4xl !font-black !text-white">
                                40%
                            </p>

                            <p class="mt-2 !text-sm !font-black !leading-6 !text-emerald-100">
                                Persentase tanaman hidup
                            </p>

                            <p class="mt-3 !text-xs !font-semibold !leading-5 !text-emerald-200">
                                Menilai jumlah tanaman yang berhasil bertahan sampai panen.
                            </p>
                        </div>

                        <div
                            class="rounded-3xl border-2 border-blue-200 bg-gradient-to-br from-blue-700 to-blue-950 p-5 shadow-lg shadow-blue-950/30">
                            <div
                                class="mb-4 flex h-11 w-11 items-center justify-center rounded-2xl border-2 border-white/40 bg-white/15 text-white">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3v18h18M7 15l4-4 3 3 5-6" />
                                </svg>
                            </div>

                            <p class="!text-4xl !font-black !text-white">
                                40%
                            </p>

                            <p class="mt-2 !text-sm !font-black !leading-6 !text-blue-100">
                                Persentase hasil panen
                            </p>

                            <p class="mt-3 !text-xs !font-semibold !leading-5 !text-blue-200">
                                Menilai perbandingan bobot panen dengan target panen.
                            </p>
                        </div>

                        <div
                            class="rounded-3xl border-2 border-amber-200 bg-gradient-to-br from-amber-600 to-orange-900 p-5 shadow-lg shadow-orange-950/30">
                            <div
                                class="mb-4 flex h-11 w-11 items-center justify-center rounded-2xl border-2 border-white/40 bg-white/15 text-white">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z" />
                                </svg>
                            </div>

                            <p class="!text-4xl !font-black !text-white">
                                10%
                            </p>

                            <p class="mt-2 !text-sm !font-black !leading-6 !text-amber-100">
                                Tingkat hama
                            </p>

                            <p class="mt-3 !text-xs !font-semibold !leading-5 !text-amber-200">
                                Menilai pengaruh serangan hama terhadap keberhasilan panen.
                            </p>
                        </div>

                        <div
                            class="rounded-3xl border-2 border-purple-200 bg-gradient-to-br from-purple-700 to-purple-950 p-5 shadow-lg shadow-purple-950/30">
                            <div
                                class="mb-4 flex h-11 w-11 items-center justify-center rounded-2xl border-2 border-white/40 bg-white/15 text-white">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 3c-3.866 0-7 3.134-7 7 0 5.25 7 11 7 11s7-5.75 7-11c0-3.866-3.134-7-7-7z" />
                                </svg>
                            </div>

                            <p class="!text-4xl !font-black !text-white">
                                10%
                            </p>

                            <p class="mt-2 !text-sm !font-black !leading-6 !text-purple-100">
                                Kondisi daun
                            </p>

                            <p class="mt-3 !text-xs !font-semibold !leading-5 !text-purple-200">
                                Menilai kesehatan tanaman berdasarkan kondisi daun dominan.
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 rounded-3xl border-2 border-white/40 bg-white/10 p-5">
                        <p class="text-sm font-black uppercase tracking-[0.18em] text-emerald-200">
                            Rumus Skor
                        </p>
                        <p class="doc-code mt-3 overflow-x-auto rounded-2xl p-4 font-mono text-sm font-black">
                            skor = hidup×0.40 + hasil×0.40 + hama×0.10 + daun×0.10
                        </p>
                    </div>

                    <div class="mt-5 grid gap-4 md:grid-cols-2">
                        <div
                            class="rounded-3xl border-2 border-amber-200 bg-gradient-to-br from-amber-600 to-orange-900 p-5 shadow-lg shadow-orange-950/30">
                            <div
                                class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl border-2 border-white/40 bg-white/15 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z" />
                                </svg>
                            </div>

                            <h3 class="!text-xl !font-black !text-white">
                                Nilai Hama
                            </h3>

                            <p class="mt-3 !text-sm !font-semibold !leading-7 !text-amber-100">
                                Tidak Ada = <span class="!font-black !text-white">100</span>,
                                Ringan = <span class="!font-black !text-white">85</span>,
                                Sedang = <span class="!font-black !text-white">60</span>,
                                Berat = <span class="!font-black !text-white">0</span>.
                            </p>

                            <div class="mt-4 grid grid-cols-2 gap-2">
                                <span
                                    class="rounded-xl border border-white/30 bg-white/15 px-3 py-2 text-center !text-xs !font-black !text-white">Tidak
                                    Ada: 100</span>
                                <span
                                    class="rounded-xl border border-white/30 bg-white/15 px-3 py-2 text-center !text-xs !font-black !text-white">Ringan:
                                    85</span>
                                <span
                                    class="rounded-xl border border-white/30 bg-white/15 px-3 py-2 text-center !text-xs !font-black !text-white">Sedang:
                                    60</span>
                                <span
                                    class="rounded-xl border border-white/30 bg-white/15 px-3 py-2 text-center !text-xs !font-black !text-white">Berat:
                                    0</span>
                            </div>
                        </div>

                        <div
                            class="rounded-3xl border-2 border-emerald-200 bg-gradient-to-br from-emerald-700 to-emerald-950 p-5 shadow-lg shadow-emerald-950/30">
                            <div
                                class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl border-2 border-white/40 bg-white/15 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 3c-3.866 0-7 3.134-7 7 0 5.25 7 11 7 11s7-5.75 7-11c0-3.866-3.134-7-7-7z" />
                                </svg>
                            </div>

                            <h3 class="!text-xl !font-black !text-white">
                                Nilai Daun
                            </h3>

                            <p class="mt-3 !text-sm !font-semibold !leading-7 !text-emerald-100">
                                Sehat = <span class="!font-black !text-white">100</span>,
                                Menguning = <span class="!font-black !text-white">70</span>,
                                Layu = <span class="!font-black !text-white">30</span>.
                            </p>

                            <div class="mt-4 grid grid-cols-3 gap-2">
                                <span
                                    class="rounded-xl border border-white/30 bg-white/15 px-3 py-2 text-center !text-xs !font-black !text-white">Sehat:
                                    100</span>
                                <span
                                    class="rounded-xl border border-white/30 bg-white/15 px-3 py-2 text-center !text-xs !font-black !text-white">Menguning:
                                    70</span>
                                <span
                                    class="rounded-xl border border-white/30 bg-white/15 px-3 py-2 text-center !text-xs !font-black !text-white">Layu:
                                    30</span>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- OUTPUT --}}
                <section id="output" class="doc-section doc-panel rounded-[2rem] p-6 sm:p-8">
                    <div class="mb-6">
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-emerald-900">
                            Hasil Sistem
                        </p>
                        <h2 class="mt-1 text-2xl font-black text-slate-950">
                            Output yang Ditampilkan
                        </h2>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        @php
                            $outputs = [
                                ['title' => 'Hasil Klasifikasi', 'desc' => 'Berhasil, Cukup, atau Gagal.'],
                                ['title' => 'Skor Evaluasi', 'desc' => 'Nilai 0-100 untuk mengukur kualitas hasil panen.'],
                                ['title' => 'Persentase Hidup', 'desc' => 'Perbandingan tanaman hidup terhadap bibit awal.'],
                                ['title' => 'Persentase Hasil', 'desc' => 'Perbandingan bobot panen terhadap target panen.'],
                                ['title' => 'Faktor Utama', 'desc' => 'Penyebab utama yang memengaruhi keputusan sistem.'],
                                ['title' => 'Rekomendasi', 'desc' => 'Saran perbaikan untuk siklus tanam berikutnya.'],
                                ['title' => 'Rincian Aturan', 'desc' => 'Jalur aturan Decision Tree yang digunakan sistem.'],
                            ];
                        @endphp

                        @foreach($outputs as $output)
                            <div class="doc-card rounded-3xl p-5">
                                <h3 class="font-black">{{ $output['title'] }}</h3>
                                <p class="mt-2 text-sm font-bold leading-7">{{ $output['desc'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>

                {{-- 5W1H --}}
                <section id="fivewoneh" class="doc-section doc-panel rounded-[2rem] p-6 sm:p-8">
                    <div class="mb-6">
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-emerald-900">
                            Penjelasan Konsep
                        </p>
                        <h2 class="mt-1 text-2xl font-black text-slate-950">
                            5W + 1H Sistem
                        </h2>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="doc-card rounded-3xl p-5">
                            <h3 class="font-black">What — Apa?</h3>
                            <p class="mt-2 text-sm font-bold leading-7">
                                Sistem mendata penanaman hingga panen dan mengevaluasi keberhasilan panen menggunakan
                                Decision Tree.
                            </p>
                        </div>

                        <div class="doc-card rounded-3xl p-5">
                            <h3 class="font-black">Why — Mengapa?</h3>
                            <p class="mt-2 text-sm font-bold leading-7">
                                Agar penilaian hasil panen lebih objektif, rapi, dan dapat dijelaskan.
                            </p>
                        </div>

                        <div class="doc-card rounded-3xl p-5">
                            <h3 class="font-black">Who — Siapa?</h3>
                            <p class="mt-2 text-sm font-bold leading-7">
                                Siswa menginput data, guru memproses evaluasi, admin mengelola akun.
                            </p>
                        </div>

                        <div class="doc-card rounded-3xl p-5">
                            <h3 class="font-black">When — Kapan?</h3>
                            <p class="mt-2 text-sm font-bold leading-7">
                                Digunakan sejak awal penanaman, pemeliharaan, panen, hingga evaluasi selesai.
                            </p>
                        </div>

                        <div class="doc-card rounded-3xl p-5">
                            <h3 class="font-black">Where — Di mana?</h3>
                            <p class="mt-2 text-sm font-bold leading-7">
                                Decision Tree diterapkan pada menu Guru → Evaluasi Panen.
                            </p>
                        </div>

                        <div class="doc-card rounded-3xl p-5">
                            <h3 class="font-black">How — Bagaimana?</h3>
                            <p class="mt-2 text-sm font-bold leading-7">
                                Sistem menghitung fitur, mengecek aturan Decision Tree, lalu menyimpan hasil evaluasi.
                            </p>
                        </div>
                    </div>
                </section>

                {{-- FAQ --}}
                <section id="faq" class="doc-section doc-panel rounded-[2rem] p-6 sm:p-8">
                    <div class="mb-6">
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-emerald-900">
                            Pertanyaan Umum
                        </p>
                        <h2 class="mt-1 text-2xl font-black text-slate-950">
                            FAQ Guru
                        </h2>
                    </div>

                    <div class="space-y-3">
                        @php
                            $faqs = [
                                ['q' => 'Sistem ini bisa apa?', 'a' => 'Sistem dapat mendata penanaman, pemeliharaan, panen, dan mengevaluasi keberhasilan panen menggunakan Rule-Based Decision Tree.'],
                                ['q' => 'Mengapa menggunakan Decision Tree?', 'a' => 'Karena bentuk keputusannya mudah dipahami, bisa dijelaskan, dan cocok untuk klasifikasi Berhasil, Cukup, atau Gagal.'],
                                ['q' => 'Kenapa hasilnya Berhasil?', 'a' => 'Karena persentase tanaman hidup dan hasil panen tinggi, hama tidak berat, dan kondisi daun tidak buruk.'],
                                ['q' => 'Kenapa hasilnya Cukup?', 'a' => 'Karena data tidak memenuhi standar Berhasil, tetapi juga tidak masuk kondisi Gagal.'],
                                ['q' => 'Kenapa hasilnya Gagal?', 'a' => 'Karena salah satu faktor utama buruk, seperti hidup kurang dari 50%, hasil kurang dari 50%, atau hama berat.'],
                                ['q' => 'Apakah ini machine learning?', 'a' => 'Tahap ini menggunakan Rule-Based Decision Tree, yaitu pohon keputusan berbasis aturan. Belum menggunakan training dataset seperti machine learning penuh.'],
                                ['q' => 'Apakah hasil bisa berubah?', 'a' => 'Bisa. Jika data penanaman, pemeliharaan, atau panen diperbarui, guru dapat memproses ulang evaluasi.'],
                            ];
                        @endphp

                        @foreach($faqs as $index => $faq)
                            <div class="doc-card overflow-hidden rounded-3xl">
                                <button type="button"
                                    @click="openFaq = openFaq === {{ $index + 1 }} ? null : {{ $index + 1 }}"
                                    class="flex w-full items-center justify-between gap-4 border-b-2 border-slate-950 bg-slate-300 px-5 py-4 text-left transition hover:bg-emerald-200">
                                    <span class="font-black text-slate-950">{{ $faq['q'] }}</span>
                                    <svg class="h-5 w-5 shrink-0 text-slate-950 transition"
                                        :class="openFaq === {{ $index + 1 }} ? 'rotate-180' : ''" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div x-show="openFaq === {{ $index + 1 }}" x-cloak class="px-5 pb-5 pt-4">
                                    <p class="text-sm font-bold leading-7">{{ $faq['a'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                {{-- TEST CASE --}}
                <section id="test-case" class="doc-section doc-panel rounded-[2rem] p-6 sm:p-8">
                    <div class="mb-6">
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-emerald-900">
                            Pengujian
                        </p>
                        <h2 class="mt-1 text-2xl font-black text-slate-950">
                            Kasus Uji Decision Tree
                        </h2>
                        <p class="mt-2 text-sm font-black leading-7 text-slate-800">
                            Tabel ini dapat digunakan guru untuk memahami hasil yang seharusnya keluar dari sistem.
                        </p>
                    </div>

                    <div
                        class="overflow-hidden rounded-3xl border-2 border-slate-950 bg-slate-950 shadow-xl shadow-slate-900/20">
                        <div class="overflow-x-auto">
                            <table class="w-full min-w-[760px] text-left text-sm">
                                <thead>
                                    <tr class="bg-emerald-300">
                                        <th
                                            class="border-b-2 border-slate-950 border-r-2 border-slate-950 px-5 py-4 font-black !text-slate-950">
                                            Kasus
                                        </th>

                                        <th
                                            class="border-b-2 border-slate-950 border-r-2 border-slate-950 px-5 py-4 font-black !text-slate-950">
                                            Input
                                        </th>

                                        <th
                                            class="border-b-2 border-slate-950 border-r-2 border-slate-950 px-5 py-4 font-black !text-slate-950">
                                            Alasan
                                        </th>

                                        <th
                                            class="border-b-2 border-slate-950 px-5 py-4 text-center font-black !text-slate-950">
                                            Output
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y-2 divide-slate-950">
                                    <tr class="bg-emerald-100">
                                        <td class="px-5 py-4 font-black text-slate-950">
                                            Berhasil
                                        </td>
                                        <td class="px-5 py-4 font-bold text-slate-950">
                                            Hidup 90%, hasil 88%, hama ringan, daun sehat
                                        </td>
                                        <td class="px-5 py-4 font-bold text-slate-950">
                                            Memenuhi syarat hidup dan hasil minimal 80%
                                        </td>
                                        <td class="px-5 py-4 text-center">
                                            <span
                                                class="inline-flex rounded-full border-2 border-slate-950 bg-emerald-300 px-4 py-1.5 text-xs font-black text-slate-950 shadow-sm">
                                                Berhasil
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="bg-amber-100">
                                        <td class="px-5 py-4 font-black text-slate-950">
                                            Cukup
                                        </td>
                                        <td class="px-5 py-4 font-bold text-slate-950">
                                            Hidup 70%, hasil 68%, hama sedang
                                        </td>
                                        <td class="px-5 py-4 font-bold text-slate-950">
                                            Tidak memenuhi Berhasil, tetapi tidak masuk Gagal
                                        </td>
                                        <td class="px-5 py-4 text-center">
                                            <span
                                                class="inline-flex rounded-full border-2 border-slate-950 bg-amber-300 px-4 py-1.5 text-xs font-black text-slate-950 shadow-sm">
                                                Cukup
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="bg-red-100">
                                        <td class="px-5 py-4 font-black text-slate-950">
                                            Gagal Hidup
                                        </td>
                                        <td class="px-5 py-4 font-bold text-slate-950">
                                            Hidup 40%, hasil 80%, hama ringan
                                        </td>
                                        <td class="px-5 py-4 font-bold text-slate-950">
                                            Persentase hidup kurang dari 50%
                                        </td>
                                        <td class="px-5 py-4 text-center">
                                            <span
                                                class="inline-flex rounded-full border-2 border-slate-950 bg-red-300 px-4 py-1.5 text-xs font-black text-slate-950 shadow-sm">
                                                Gagal
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="bg-red-100">
                                        <td class="px-5 py-4 font-black text-slate-950">
                                            Gagal Hasil
                                        </td>
                                        <td class="px-5 py-4 font-bold text-slate-950">
                                            Hidup 90%, hasil 30%, hama ringan
                                        </td>
                                        <td class="px-5 py-4 font-bold text-slate-950">
                                            Persentase hasil kurang dari 50%
                                        </td>
                                        <td class="px-5 py-4 text-center">
                                            <span
                                                class="inline-flex rounded-full border-2 border-slate-950 bg-red-300 px-4 py-1.5 text-xs font-black text-slate-950 shadow-sm">
                                                Gagal
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="bg-red-100">
                                        <td class="px-5 py-4 font-black text-slate-950">
                                            Gagal Hama
                                        </td>
                                        <td class="px-5 py-4 font-bold text-slate-950">
                                            Hidup 85%, hasil 85%, hama berat
                                        </td>
                                        <td class="px-5 py-4 font-bold text-slate-950">
                                            Hama berat langsung menjadi faktor kegagalan
                                        </td>
                                        <td class="px-5 py-4 text-center">
                                            <span
                                                class="inline-flex rounded-full border-2 border-slate-950 bg-red-300 px-4 py-1.5 text-xs font-black text-slate-950 shadow-sm">
                                                Gagal
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                {{-- FINAL NOTE --}}
                <section class="doc-section doc-dark rounded-[2rem] p-6 sm:p-8">
                    <div class="flex flex-col gap-4 md:flex-row md:items-start">
                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl border-2 border-white bg-emerald-200 text-emerald-950">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>

                        <div>
                            <h2 class="text-xl font-black">
                                Kesimpulan Dokumentasi
                            </h2>
                            <p class="mt-2 text-sm font-bold leading-7">
                                Decision Tree pada sistem ini diterapkan di menu <strong>Evaluasi Panen</strong>. Guru
                                menjadi aktor utama yang memproses evaluasi, sedangkan siswa menjadi sumber data melalui
                                input penanaman, pemeliharaan, dan panen. Sistem menghasilkan klasifikasi, skor, faktor
                                utama, rekomendasi, dan rincian aturan sehingga hasil evaluasi dapat dijelaskan secara
                                objektif.
                            </p>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>
</x-app-layout>