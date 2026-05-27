{{-- Shared sidebar + layout styles for pages with sidebar --}}
<style>
    body { background: #f1f5f9; overflow-x: hidden; }

    #sidebar {
        width: 260px; min-height: 100vh;
        background: linear-gradient(180deg, #022c22 0%, #064e3b 40%, #065f46 100%);
        position: fixed; top: 0; left: 0; z-index: 40;
        display: flex; flex-direction: column;
        transition: transform .3s cubic-bezier(.4,0,.2,1);
        box-shadow: 4px 0 24px rgba(0,0,0,.15);
    }
    .sidebar-logo { padding: 1.5rem 1.25rem 1.25rem; border-bottom: 1px solid rgba(255,255,255,.07); }
    .logo-badge { width: 40px; height: 40px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(16,185,129,.4); }
    .sidebar-nav { padding: .875rem; flex: 1; overflow-y: auto; }
    .nav-section-title { font-size: .625rem; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; color: rgba(255,255,255,.3); padding: .75rem .5rem .5rem; margin-bottom: .25rem; }
    .nav-link { display: flex; align-items: center; gap: .75rem; padding: .65rem .875rem; border-radius: .75rem; color: rgba(255,255,255,.6); font-size: .875rem; font-weight: 500; text-decoration: none; transition: all .2s; margin-bottom: 2px; position: relative; }
    .nav-link:hover { background: rgba(255,255,255,.08); color: #fff; }
    .nav-link.active { background: rgba(255,255,255,.12); color: #fff; font-weight: 600; }
    .nav-link.active::before { content: ''; position: absolute; left: 0; top: 20%; height: 60%; width: 3px; background: #34d399; border-radius: 0 4px 4px 0; }
    .nav-link .nav-icon { width: 32px; height: 32px; border-radius: .5rem; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,.07); flex-shrink: 0; }
    .nav-link.active .nav-icon { background: rgba(52,211,153,.2); }
    .sidebar-footer { padding: 1rem .875rem; border-top: 1px solid rgba(255,255,255,.07); }
    .user-card { display: flex; align-items: center; gap: .75rem; padding: .625rem .75rem; border-radius: .875rem; background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.08); }
    .user-avatar { width: 34px; height: 34px; border-radius: 50%; background: linear-gradient(135deg, #34d399, #059669); display: flex; align-items: center; justify-content: center; font-size: .85rem; font-weight: 700; color: #fff; }

    #main-content { margin-left: 260px; min-height: 100vh; }
    .topbar { background: rgba(255,255,255,.9); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(0,0,0,.06); padding: .875rem 1.75rem; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 30; }

    .data-table { width: 100%; border-collapse: separate; border-spacing: 0; }
    .data-table thead th { background: #f8fafc; padding: .75rem 1rem; font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: #64748b; border-bottom: 1.5px solid #e2e8f0; text-align: left; }
    .data-table tbody td { padding: .875rem 1rem; font-size: .875rem; color: #334155; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    .data-table tbody tr { transition: background .15s; }
    .data-table tbody tr:hover { background: #f0fdf6; }
    .data-table tbody tr:last-child td { border-bottom: none; }

    .btn-icon { width: 32px; height: 32px; border-radius: .5rem; border: 1.5px solid #e2e8f0; background: #fff; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all .2s; color: #64748b; }
    .btn-icon:hover { border-color: #a7f3d0; color: #059669; background: #f0fdf6; }
    .btn-icon.danger:hover { border-color: #fca5a5; color: #ef4444; background: #fef2f2; }

    #sidebarOverlay { display: none; position: fixed; inset: 0; z-index: 35; background: rgba(0,0,0,.4); }
    @media (max-width: 1024px) {
        #sidebar { transform: translateX(-100%); }
        #sidebar.open { transform: translateX(0); }
        #main-content { margin-left: 0; }
        #sidebarOverlay.open { display: block; }
    }
</style>
