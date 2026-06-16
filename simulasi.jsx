import React, { useState, useEffect } from 'react';
import { 
  Users, User, LogOut, Home, Leaf, Droplets, 
  Tractor, BarChart3, Plus, Trash2, Edit, AlertCircle, CheckCircle2
} from 'lucide-react';

// --- DATA AWAL (MOCK DATABASE) ---
const initialUsers = [
  { id: 1, username: 'admin', password: '123', role: 'admin', name: 'Admin Sistem' },
  { id: 2, username: 'guru1', password: '123', role: 'guru', name: 'Budi Santoso (Guru ATPH)' },
  { id: 3, username: 'siswa1', password: '123', role: 'siswa', name: 'Murni Mutpadilah' },
];

const initialPenanaman = [
  { id: 1, idSiswa: 3, tanaman: 'Pakcoy', tanggal: '2026-01-10', jumlahBibit: 100, lokasi: 'Greenhouse 1' }
];

const initialPemeliharaan = [
  { id: 1, idSiswa: 3, idPenanaman: 1, tanggal: '2026-01-15', kegiatan: 'Penyiraman & Nutrisi AB Mix', tinggiTanaman: 10, kondisi: 'Sehat' }
];

const initialPanen = [
  { id: 1, idSiswa: 3, idPenanaman: 1, tanggal: '2026-02-10', tanamanHidup: 85, tanamanMati: 15, beratPanenKg: 20 }
];

export default function App() {
  // --- STATE MANAGEMENT ---
  const [user, setUser] = useState(null);
  const [currentView, setCurrentView] = useState('dashboard');
  
  // Tables State
  const [users, setUsers] = useState(initialUsers);
  const [penanaman, setPenanaman] = useState(initialPenanaman);
  const [pemeliharaan, setPemeliharaan] = useState(initialPemeliharaan);
  const [panen, setPanen] = useState(initialPanen);

  // Form State
  const [loginForm, setLoginForm] = useState({ username: '', password: '' });
  const [errorMsg, setErrorMsg] = useState('');

  // --- FUNGSI LOGIN & LOGOUT ---
  const handleLogin = (e) => {
    e.preventDefault();
    const foundUser = users.find(u => u.username === loginForm.username && u.password === loginForm.password);
    if (foundUser) {
      setUser(foundUser);
      setCurrentView('dashboard');
      setErrorMsg('');
    } else {
      setErrorMsg('Username atau password salah!');
    }
  };

  const handleLogout = () => {
    setUser(null);
    setLoginForm({ username: '', password: '' });
    setCurrentView('dashboard');
  };

  // --- KOMPONEN: LOGIN ---
  if (!user) {
    return (
      <div className="min-h-screen bg-gray-100 flex items-center justify-center p-4">
        <div className="bg-white p-8 rounded-xl shadow-lg max-w-md w-full border-t-4 border-green-600">
          <div className="text-center mb-8">
            <div className="bg-green-100 p-3 rounded-full inline-block mb-3">
              <Leaf className="w-8 h-8 text-green-600" />
            </div>
            <h1 className="text-2xl font-bold text-gray-800">Sistem Pendataan Penanaman</h1>
            <p className="text-sm text-gray-500">SMK IT Al-Hawari</p>
          </div>
          
          {errorMsg && (
            <div className="mb-4 p-3 bg-red-100 text-red-700 rounded-lg flex items-center text-sm">
              <AlertCircle className="w-4 h-4 mr-2" /> {errorMsg}
            </div>
          )}

          <form onSubmit={handleLogin} className="space-y-4">
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-1">Username</label>
              <input 
                type="text" 
                className="w-full p-2 border rounded focus:ring-green-500 focus:border-green-500"
                value={loginForm.username}
                onChange={(e) => setLoginForm({...loginForm, username: e.target.value})}
                required
              />
            </div>
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-1">Password</label>
              <input 
                type="password" 
                className="w-full p-2 border rounded focus:ring-green-500 focus:border-green-500"
                value={loginForm.password}
                onChange={(e) => setLoginForm({...loginForm, password: e.target.value})}
                required
              />
            </div>
            <button type="submit" className="w-full bg-green-600 text-white p-2 rounded-lg hover:bg-green-700 transition font-medium">
              Login
            </button>
          </form>
          <div className="mt-4 text-xs text-center text-gray-400">
            Hint Role Login:<br/>
            Admin: admin/123 | Guru: guru1/123 | Siswa: siswa1/123
          </div>
        </div>
      </div>
    );
  }

  // --- MAIN LAYOUT (SIDEBAR & CONTENT) ---
  const NavItem = ({ id, icon: Icon, label, roles }) => {
    if (!roles.includes(user.role)) return null;
    return (
      <button 
        onClick={() => setCurrentView(id)}
        className={`w-full flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition ${
          currentView === id ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-600 hover:bg-gray-50'
        }`}
      >
        <Icon className="w-5 h-5" />
        <span>{label}</span>
      </button>
    );
  };

  return (
    <div className="flex h-screen bg-gray-50">
      {/* Sidebar */}
      <div className="w-64 bg-white border-r shadow-sm flex flex-col">
        <div className="p-4 border-b flex items-center space-x-3">
          <div className="bg-green-600 p-2 rounded-lg">
            <Leaf className="w-6 h-6 text-white" />
          </div>
          <div>
            <h2 className="font-bold text-gray-800 text-sm">SI Tanam</h2>
            <p className="text-xs text-gray-500">SMK IT Al-Hawari</p>
          </div>
        </div>
        
        <div className="flex-1 overflow-y-auto p-4">
          <NavItem id="dashboard" icon={Home} label="Dashboard" roles={['admin', 'guru', 'siswa']} />
          <NavItem id="pengguna" icon={Users} label="Kelola Pengguna" roles={['admin']} />
          <NavItem id="penanaman" icon={Tractor} label="Data Penanaman" roles={['guru', 'siswa']} />
          <NavItem id="pemeliharaan" icon={Droplets} label="Data Pemeliharaan" roles={['guru', 'siswa']} />
          <NavItem id="panen" icon={Leaf} label="Data Panen" roles={['guru', 'siswa']} />
          <NavItem id="evaluasi" icon={BarChart3} label="Evaluasi Panen" roles={['guru', 'siswa']} />
          <NavItem id="profil" icon={User} label="Profil Saya" roles={['admin', 'guru', 'siswa']} />
        </div>

        <div className="p-4 border-t">
          <button onClick={handleLogout} className="w-full flex items-center space-x-3 px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg transition">
            <LogOut className="w-5 h-5" />
            <span>Logout</span>
          </button>
        </div>
      </div>

      {/* Main Content */}
      <div className="flex-1 flex flex-col overflow-hidden">
        {/* Topbar */}
        <header className="bg-white border-b h-16 flex items-center justify-between px-8">
          <h2 className="text-xl font-semibold text-gray-800 capitalize">
            {currentView.replace(/([A-Z])/g, ' $1').trim()}
          </h2>
          <div className="flex items-center space-x-3">
            <div className="text-right">
              <p className="text-sm font-semibold text-gray-800">{user.name}</p>
              <p className="text-xs text-green-600 capitalize">{user.role}</p>
            </div>
            <div className="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold">
              {user.name.charAt(0)}
            </div>
          </div>
        </header>

        {/* Content Area */}
        <main className="flex-1 overflow-y-auto p-8">
          {currentView === 'dashboard' && <ViewDashboard user={user} users={users} penanaman={penanaman} />}
          {currentView === 'pengguna' && <ViewPengguna users={users} setUsers={setUsers} />}
          {currentView === 'penanaman' && <ViewPenanaman data={penanaman} setData={setPenanaman} user={user} />}
          {currentView === 'pemeliharaan' && <ViewPemeliharaan data={pemeliharaan} setData={setPemeliharaan} penanaman={penanaman} user={user} />}
          {currentView === 'panen' && <ViewPanen data={panen} setData={setPanen} penanaman={penanaman} user={user} />}
          {currentView === 'evaluasi' && <ViewEvaluasi panen={panen} penanaman={penanaman} />}
          {currentView === 'profil' && <ViewProfil user={user} />}
        </main>
      </div>
    </div>
  );
}

// ==========================================
// VIEWS COMPONENTS
// ==========================================

function ViewDashboard({ user, users, penanaman }) {
  if (user.role === 'admin') {
    const totalGuru = users.filter(u => u.role === 'guru').length;
    const totalSiswa = users.filter(u => u.role === 'siswa').length;
    
    return (
      <div className="space-y-6">
        <div className="bg-green-600 rounded-2xl p-8 text-white shadow-md">
          <h2 className="text-2xl font-bold mb-2">Selamat Datang, {user.name} 👋</h2>
          <p className="text-green-100">Kelola pengguna dan konfigurasi sistem pada halaman ini.</p>
        </div>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center space-x-4">
            <div className="p-4 bg-blue-50 text-blue-600 rounded-lg"><Users className="w-8 h-8" /></div>
            <div>
              <p className="text-gray-500 text-sm">Total Guru</p>
              <p className="text-3xl font-bold text-gray-800">{totalGuru}</p>
            </div>
          </div>
          <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center space-x-4">
            <div className="p-4 bg-green-50 text-green-600 rounded-lg"><Users className="w-8 h-8" /></div>
            <div>
              <p className="text-gray-500 text-sm">Total Siswa</p>
              <p className="text-3xl font-bold text-gray-800">{totalSiswa}</p>
            </div>
          </div>
        </div>
      </div>
    );
  }

  return (
    <div className="space-y-6">
      <div className="bg-green-600 rounded-2xl p-8 text-white shadow-md">
        <h2 className="text-2xl font-bold mb-2">Selamat Datang di SI Tanam 👋</h2>
        <p className="text-green-100">Pantau dan kelola kegiatan praktik pertanian Anda.</p>
      </div>
      <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 className="font-semibold text-gray-800 mb-4">Statistik Penanaman Aktif</h3>
        <div className="flex items-center space-x-4">
          <div className="p-4 bg-orange-50 text-orange-600 rounded-lg"><Tractor className="w-8 h-8" /></div>
          <div>
            <p className="text-gray-500 text-sm">Total Proyek Penanaman</p>
            <p className="text-3xl font-bold text-gray-800">{penanaman.length}</p>
          </div>
        </div>
      </div>
    </div>
  );
}

function ViewPengguna({ users, setUsers }) {
  const [formData, setFormData] = useState({ username: '', password: '', role: 'siswa', name: '' });

  const handleAdd = (e) => {
    e.preventDefault();
    setUsers([...users, { ...formData, id: Date.now() }]);
    setFormData({ username: '', password: '', role: 'siswa', name: '' });
  };

  const handleDelete = (id) => {
    if(confirm('Hapus pengguna ini?')) {
      setUsers(users.filter(u => u.id !== id));
    }
  };

  return (
    <div className="space-y-6">
      <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 className="font-semibold text-gray-800 mb-4 flex items-center"><Plus className="w-5 h-5 mr-2" /> Tambah Pengguna Baru</h3>
        <form onSubmit={handleAdd} className="grid grid-cols-1 md:grid-cols-4 gap-4">
          <input type="text" placeholder="Nama Lengkap" className="border p-2 rounded" required value={formData.name} onChange={e => setFormData({...formData, name: e.target.value})} />
          <input type="text" placeholder="Username" className="border p-2 rounded" required value={formData.username} onChange={e => setFormData({...formData, username: e.target.value})} />
          <input type="text" placeholder="Password" className="border p-2 rounded" required value={formData.password} onChange={e => setFormData({...formData, password: e.target.value})} />
          <div className="flex space-x-2">
            <select className="border p-2 rounded flex-1" value={formData.role} onChange={e => setFormData({...formData, role: e.target.value})}>
              <option value="siswa">Siswa</option>
              <option value="guru">Guru</option>
              <option value="admin">Admin</option>
            </select>
            <button type="submit" className="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Simpan</button>
          </div>
        </form>
      </div>

      <div className="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table className="w-full text-left border-collapse">
          <thead>
            <tr className="bg-gray-50 border-b">
              <th className="p-4 font-medium text-gray-600">Nama</th>
              <th className="p-4 font-medium text-gray-600">Username</th>
              <th className="p-4 font-medium text-gray-600">Role</th>
              <th className="p-4 font-medium text-gray-600 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody>
            {users.map((u) => (
              <tr key={u.id} className="border-b hover:bg-gray-50">
                <td className="p-4 text-gray-800">{u.name}</td>
                <td className="p-4 text-gray-600">{u.username}</td>
                <td className="p-4"><span className={`px-2 py-1 text-xs rounded-full ${u.role === 'admin' ? 'bg-red-100 text-red-700' : u.role === 'guru' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700'}`}>{u.role}</span></td>
                <td className="p-4 text-right">
                  {u.username !== 'admin' && (
                    <button onClick={() => handleDelete(u.id)} className="text-red-500 hover:text-red-700 p-1"><Trash2 className="w-5 h-5" /></button>
                  )}
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  );
}

function ViewPenanaman({ data, setData, user }) {
  const [form, setForm] = useState({ tanaman: '', tanggal: '', jumlahBibit: '', lokasi: '' });

  const handleSubmit = (e) => {
    e.preventDefault();
    setData([...data, { ...form, id: Date.now(), idSiswa: user.id }]);
    setForm({ tanaman: '', tanggal: '', jumlahBibit: '', lokasi: '' });
  };

  return (
    <div className="space-y-6">
      {user.role === 'siswa' && (
        <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
          <h3 className="font-semibold text-gray-800 mb-4">Form Data Penanaman</h3>
          <form onSubmit={handleSubmit} className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <input type="text" placeholder="Jenis Tanaman (cth: Pakcoy)" className="border p-2 rounded" required value={form.tanaman} onChange={e => setForm({...form, tanaman: e.target.value})} />
            <input type="date" className="border p-2 rounded" required value={form.tanggal} onChange={e => setForm({...form, tanggal: e.target.value})} />
            <input type="number" placeholder="Jml Bibit" className="border p-2 rounded" required value={form.jumlahBibit} onChange={e => setForm({...form, jumlahBibit: e.target.value})} />
            <input type="text" placeholder="Lokasi Lahan" className="border p-2 rounded" required value={form.lokasi} onChange={e => setForm({...form, lokasi: e.target.value})} />
            <button type="submit" className="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Simpan Data</button>
          </form>
        </div>
      )}

      <div className="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table className="w-full text-left border-collapse">
          <thead>
            <tr className="bg-gray-50 border-b">
              <th className="p-4 text-gray-600">ID</th>
              <th className="p-4 text-gray-600">Tanaman</th>
              <th className="p-4 text-gray-600">Tanggal Tanam</th>
              <th className="p-4 text-gray-600">Jml Bibit</th>
              <th className="p-4 text-gray-600">Lokasi</th>
            </tr>
          </thead>
          <tbody>
            {data.map((d) => (
              <tr key={d.id} className="border-b hover:bg-gray-50">
                <td className="p-4 font-mono text-sm text-gray-500">#{d.id}</td>
                <td className="p-4 font-medium text-gray-800">{d.tanaman}</td>
                <td className="p-4 text-gray-600">{d.tanggal}</td>
                <td className="p-4 text-gray-600">{d.jumlahBibit}</td>
                <td className="p-4 text-gray-600">{d.lokasi}</td>
              </tr>
            ))}
            {data.length === 0 && <tr><td colSpan="5" className="p-4 text-center text-gray-500">Belum ada data penanaman</td></tr>}
          </tbody>
        </table>
      </div>
    </div>
  );
}

function ViewPemeliharaan({ data, setData, penanaman, user }) {
  const [form, setForm] = useState({ idPenanaman: '', tanggal: '', kegiatan: '', tinggiTanaman: '', kondisi: 'Sehat' });

  const handleSubmit = (e) => {
    e.preventDefault();
    setData([...data, { ...form, id: Date.now(), idSiswa: user.id }]);
    setForm({ idPenanaman: '', tanggal: '', kegiatan: '', tinggiTanaman: '', kondisi: 'Sehat' });
  };

  return (
    <div className="space-y-6">
      {user.role === 'siswa' && (
        <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
          <h3 className="font-semibold text-gray-800 mb-4">Catat Kegiatan Pemeliharaan</h3>
          <form onSubmit={handleSubmit} className="grid grid-cols-1 md:grid-cols-3 gap-4">
            <select className="border p-2 rounded" required value={form.idPenanaman} onChange={e => setForm({...form, idPenanaman: e.target.value})}>
              <option value="">-- Pilih Data Tanaman --</option>
              {penanaman.map(p => <option key={p.id} value={p.id}>{p.tanaman} ({p.lokasi})</option>)}
            </select>
            <input type="date" className="border p-2 rounded" required value={form.tanggal} onChange={e => setForm({...form, tanggal: e.target.value})} />
            <input type="text" placeholder="Kegiatan (Penyiraman, dll)" className="border p-2 rounded" required value={form.kegiatan} onChange={e => setForm({...form, kegiatan: e.target.value})} />
            <input type="number" placeholder="Tinggi Tanaman (cm)" className="border p-2 rounded" required value={form.tinggiTanaman} onChange={e => setForm({...form, tinggiTanaman: e.target.value})} />
            <select className="border p-2 rounded" required value={form.kondisi} onChange={e => setForm({...form, kondisi: e.target.value})}>
              <option value="Sehat">Sehat</option>
              <option value="Terserang Hama">Terserang Hama</option>
              <option value="Layu">Layu</option>
            </select>
            <button type="submit" className="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Simpan Data</button>
          </form>
        </div>
      )}

      <div className="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table className="w-full text-left border-collapse">
          <thead>
            <tr className="bg-gray-50 border-b">
              <th className="p-4 text-gray-600">ID Tanam</th>
              <th className="p-4 text-gray-600">Tanggal</th>
              <th className="p-4 text-gray-600">Kegiatan</th>
              <th className="p-4 text-gray-600">Tinggi (cm)</th>
              <th className="p-4 text-gray-600">Kondisi</th>
            </tr>
          </thead>
          <tbody>
            {data.map((d) => (
              <tr key={d.id} className="border-b hover:bg-gray-50">
                <td className="p-4 font-mono text-sm text-gray-500">#{d.idPenanaman}</td>
                <td className="p-4 text-gray-600">{d.tanggal}</td>
                <td className="p-4 text-gray-800">{d.kegiatan}</td>
                <td className="p-4 text-gray-600">{d.tinggiTanaman}</td>
                <td className="p-4">
                  <span className={`px-2 py-1 text-xs rounded-full ${d.kondisi === 'Sehat' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}`}>{d.kondisi}</span>
                </td>
              </tr>
            ))}
             {data.length === 0 && <tr><td colSpan="5" className="p-4 text-center text-gray-500">Belum ada data pemeliharaan</td></tr>}
          </tbody>
        </table>
      </div>
    </div>
  );
}

function ViewPanen({ data, setData, penanaman, user }) {
  const [form, setForm] = useState({ idPenanaman: '', tanggal: '', tanamanHidup: '', tanamanMati: '', beratPanenKg: '' });

  const handleSubmit = (e) => {
    e.preventDefault();
    setData([...data, { ...form, id: Date.now(), idSiswa: user.id }]);
    setForm({ idPenanaman: '', tanggal: '', tanamanHidup: '', tanamanMati: '', beratPanenKg: '' });
  };

  return (
    <div className="space-y-6">
       {user.role === 'siswa' && (
        <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
          <h3 className="font-semibold text-gray-800 mb-4">Catat Hasil Panen</h3>
          <form onSubmit={handleSubmit} className="grid grid-cols-1 md:grid-cols-3 gap-4">
            <select className="border p-2 rounded" required value={form.idPenanaman} onChange={e => setForm({...form, idPenanaman: e.target.value})}>
              <option value="">-- Pilih Data Tanaman --</option>
              {penanaman.map(p => <option key={p.id} value={p.id}>{p.tanaman} ({p.lokasi})</option>)}
            </select>
            <input type="date" className="border p-2 rounded" required value={form.tanggal} onChange={e => setForm({...form, tanggal: e.target.value})} />
            <input type="number" placeholder="Jml Tanaman Hidup" className="border p-2 rounded" required value={form.tanamanHidup} onChange={e => setForm({...form, tanamanHidup: e.target.value})} />
            <input type="number" placeholder="Jml Tanaman Mati" className="border p-2 rounded" required value={form.tanamanMati} onChange={e => setForm({...form, tanamanMati: e.target.value})} />
            <input type="number" step="0.1" placeholder="Berat Panen (Kg)" className="border p-2 rounded" required value={form.beratPanenKg} onChange={e => setForm({...form, beratPanenKg: e.target.value})} />
            <button type="submit" className="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Simpan Panen</button>
          </form>
        </div>
      )}

      <div className="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table className="w-full text-left border-collapse">
          <thead>
            <tr className="bg-gray-50 border-b">
              <th className="p-4 text-gray-600">ID Tanam</th>
              <th className="p-4 text-gray-600">Tanggal Panen</th>
              <th className="p-4 text-gray-600">Hidup</th>
              <th className="p-4 text-gray-600">Mati</th>
              <th className="p-4 text-gray-600">Total Berat (Kg)</th>
            </tr>
          </thead>
          <tbody>
            {data.map((d) => (
              <tr key={d.id} className="border-b hover:bg-gray-50">
                <td className="p-4 font-mono text-sm text-gray-500">#{d.idPenanaman}</td>
                <td className="p-4 text-gray-600">{d.tanggal}</td>
                <td className="p-4 text-green-600 font-semibold">{d.tanamanHidup}</td>
                <td className="p-4 text-red-600 font-semibold">{d.tanamanMati}</td>
                <td className="p-4 text-gray-800 font-bold">{d.beratPanenKg} kg</td>
              </tr>
            ))}
             {data.length === 0 && <tr><td colSpan="5" className="p-4 text-center text-gray-500">Belum ada data panen</td></tr>}
          </tbody>
        </table>
      </div>
    </div>
  );
}

function ViewEvaluasi({ panen, penanaman }) {
  // ALGORITMA DECISION TREE (SIMULASI BERDASARKAN SKRIPSI)
  // Aturan Evaluasi IF-THEN sederhana:
  // Jika rasio hidup >= 80% -> Berhasil (Sangat Baik)
  // Jika rasio hidup >= 50% AND < 80% -> Cukup Berhasil
  // Jika rasio hidup < 50% -> Gagal
  
  const generateEvaluasi = () => {
    return panen.map(p => {
      const tanam = penanaman.find(t => t.id == p.idPenanaman);
      if(!tanam) return null;
      
      const targetBibit = tanam.jumlahBibit;
      const persenHidup = (p.tanamanHidup / targetBibit) * 100;
      
      let klasifikasi = "";
      let warna = "";

      // Decision Tree Logic
      if (persenHidup >= 80) {
        klasifikasi = "Berhasil (Sangat Baik)";
        warna = "bg-green-100 text-green-800";
      } else if (persenHidup >= 50) {
        klasifikasi = "Cukup Berhasil";
        warna = "bg-yellow-100 text-yellow-800";
      } else {
        klasifikasi = "Gagal Panen";
        warna = "bg-red-100 text-red-800";
      }

      return { ...p, tanaman: tanam.tanaman, persenHidup, klasifikasi, warna };
    }).filter(Boolean);
  };

  const hasilEvaluasi = generateEvaluasi();

  return (
    <div className="space-y-6">
      <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6">
        <h3 className="font-semibold text-gray-800 mb-2 flex items-center"><BarChart3 className="w-5 h-5 mr-2"/> Analisis Algoritma Decision Tree</h3>
        <p className="text-sm text-gray-600">Sistem melakukan evaluasi otomatis dengan membandingkan jumlah bibit awal dengan tanaman hidup saat panen.</p>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        {hasilEvaluasi.map((hasil, idx) => (
          <div key={idx} className="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div className="flex justify-between items-start mb-4">
              <div>
                <h4 className="font-bold text-xl text-gray-800">{hasil.tanaman}</h4>
                <p className="text-xs text-gray-500">ID Penanaman: #{hasil.idPenanaman}</p>
              </div>
              <span className={`px-3 py-1 rounded-full text-sm font-semibold ${hasil.warna}`}>
                {hasil.klasifikasi}
              </span>
            </div>
            
            <div className="space-y-2 mt-4 text-sm text-gray-700">
              <div className="flex justify-between border-b pb-1">
                <span>Tanaman Hidup:</span>
                <span className="font-semibold">{hasil.tanamanHidup} polybag</span>
              </div>
              <div className="flex justify-between border-b pb-1">
                <span>Tanaman Mati:</span>
                <span className="font-semibold text-red-500">{hasil.tanamanMati} polybag</span>
              </div>
              <div className="flex justify-between border-b pb-1">
                <span>Persentase Keberhasilan:</span>
                <span className="font-bold">{hasil.persenHidup.toFixed(1)}%</span>
              </div>
              <div className="flex justify-between">
                <span>Total Berat Panen:</span>
                <span className="font-bold text-green-600">{hasil.beratPanenKg} kg</span>
              </div>
            </div>
          </div>
        ))}
        {hasilEvaluasi.length === 0 && (
          <div className="col-span-2 text-center py-10 text-gray-500">Belum ada data evaluasi yang dapat diproses.</div>
        )}
      </div>
    </div>
  );
}

function ViewProfil({ user }) {
  return (
    <div className="max-w-xl">
      <div className="bg-white p-8 rounded-xl shadow-sm border border-gray-100 text-center">
        <div className="w-24 h-24 bg-green-100 rounded-full mx-auto flex items-center justify-center mb-4">
          <User className="w-12 h-12 text-green-600" />
        </div>
        <h2 className="text-2xl font-bold text-gray-800">{user.name}</h2>
        <p className="text-green-600 font-medium capitalize mb-6">{user.role}</p>
        
        <div className="text-left space-y-4 border-t pt-6">
          <div>
            <label className="text-xs text-gray-500 uppercase font-semibold">Username Login</label>
            <p className="text-gray-800 font-medium">{user.username}</p>
          </div>
          <div>
            <label className="text-xs text-gray-500 uppercase font-semibold">Akses Sistem</label>
            <p className="text-gray-800 font-medium">Hak akses sebagai {user.role} aktif.</p>
          </div>
        </div>
      </div>
    </div>
  );
}