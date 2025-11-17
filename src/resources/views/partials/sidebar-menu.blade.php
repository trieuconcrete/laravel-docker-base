<!-- Dashboard -->
<a href="{{ route('admin.dashboard') }}" 
   class="flex items-center px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 backdrop-blur-sm text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}"
   data-menu="dashboard">
    <i class="fas fa-home w-5"></i>
    <span class="ml-3 font-medium">Dashboard</span>
</a>

<!-- CMS Module -->
<div>
    <button @click="activeMenu = (activeMenu === 'cms' ? '' : 'cms')" 
            class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition-all {{ request()->is('admin/cms/*') ? 'bg-white/20 backdrop-blur-sm text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
        <div class="flex items-center">
            <i class="fas fa-file-alt w-5"></i>
            <span class="ml-3 font-medium">CMS</span>
        </div>
        <i :class="activeMenu === 'cms' ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs"></i>
    </button>
    <div x-show="activeMenu === 'cms'" x-cloak x-collapse class="ml-8 mt-2 space-y-1">
        <a href="{{ route('admin.cms.posts') }}" class="block px-4 py-2 text-sm rounded transition-all {{ request()->routeIs('admin.cms.posts') ? 'text-white font-semibold' : 'text-white/60 hover:text-white' }}">Bài viết</a>
        <a href="{{ route('admin.cms.categories') }}" class="block px-4 py-2 text-sm rounded transition-all {{ request()->routeIs('admin.cms.categories') ? 'text-white font-semibold' : 'text-white/60 hover:text-white' }}">Danh mục</a>
        <a href="{{ route('admin.cms.media') }}" class="block px-4 py-2 text-sm rounded transition-all {{ request()->routeIs('admin.cms.media') ? 'text-white font-semibold' : 'text-white/60 hover:text-white' }}">Media</a>
        <a href="{{ route('admin.cms.pages') }}" class="block px-4 py-2 text-sm rounded transition-all {{ request()->routeIs('admin.cms.pages') ? 'text-white font-semibold' : 'text-white/60 hover:text-white' }}">Trang</a>
    </div>
</div>

<!-- CRM Module -->
<div>
    <button @click="activeMenu = (activeMenu === 'crm' ? '' : 'crm')" 
            class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition-all {{ request()->is('admin/crm/*') ? 'bg-white/20 backdrop-blur-sm text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
        <div class="flex items-center">
            <i class="fas fa-user-tie w-5"></i>
            <span class="ml-3 font-medium">CRM</span>
        </div>
        <i :class="activeMenu === 'crm' ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs"></i>
    </button>
    <div x-show="activeMenu === 'crm'" x-cloak x-collapse class="ml-8 mt-2 space-y-1">
        <a href="{{ route('admin.crm.contacts') }}" class="block px-4 py-2 text-sm rounded transition-all {{ request()->routeIs('admin.crm.contacts') ? 'text-white font-semibold' : 'text-white/60 hover:text-white' }}">Liên hệ</a>
        <a href="{{ route('admin.crm.leads') }}" class="block px-4 py-2 text-sm rounded transition-all {{ request()->routeIs('admin.crm.leads') ? 'text-white font-semibold' : 'text-white/60 hover:text-white' }}">Khách hàng tiềm năng</a>
        <a href="{{ route('admin.crm.opportunities') }}" class="block px-4 py-2 text-sm rounded transition-all {{ request()->routeIs('admin.crm.opportunities') ? 'text-white font-semibold' : 'text-white/60 hover:text-white' }}">Cơ hội</a>
        <a href="{{ route('admin.crm.companies') }}" class="block px-4 py-2 text-sm rounded transition-all {{ request()->routeIs('admin.crm.companies') ? 'text-white font-semibold' : 'text-white/60 hover:text-white' }}">Công ty</a>
        <a href="{{ route('admin.crm.deals') }}" class="block px-4 py-2 text-sm rounded transition-all {{ request()->routeIs('admin.crm.deals') ? 'text-white font-semibold' : 'text-white/60 hover:text-white' }}">Giao dịch</a>
        <a href="{{ route('admin.crm.activities') }}" class="block px-4 py-2 text-sm rounded transition-all {{ request()->routeIs('admin.crm.activities') ? 'text-white font-semibold' : 'text-white/60 hover:text-white' }}">Hoạt động</a>
    </div>
</div>

<!-- E-commerce Module -->
<div>
    <button @click="activeMenu = (activeMenu === 'ecommerce' ? '' : 'ecommerce')" 
            class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition-all {{ (request()->is('admin/products*') || request()->is('admin/orders*') || request()->is('admin/customers*') || request()->is('admin/inventory*') || request()->is('admin/analytics*')) ? 'bg-white/20 backdrop-blur-sm text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
        <div class="flex items-center">
            <i class="fas fa-shopping-cart w-5"></i>
            <span class="ml-3 font-medium">E-commerce</span>
        </div>
        <i :class="activeMenu === 'ecommerce' ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs"></i>
    </button>
    <div x-show="activeMenu === 'ecommerce'" x-cloak x-collapse class="ml-8 mt-2 space-y-1">
        <a href="{{ route('admin.products.index') }}" class="block px-4 py-2 text-sm rounded transition-all {{ request()->routeIs('admin.products.*') ? 'text-white font-semibold' : 'text-white/60 hover:text-white' }}">Sản phẩm</a>
        <a href="{{ route('admin.orders.index') }}" class="block px-4 py-2 text-sm rounded transition-all {{ request()->routeIs('admin.orders.*') ? 'text-white font-semibold' : 'text-white/60 hover:text-white' }}">Đơn hàng</a>
        <a href="{{ route('admin.customers.index') }}" class="block px-4 py-2 text-sm rounded transition-all {{ request()->routeIs('admin.customers.*') ? 'text-white font-semibold' : 'text-white/60 hover:text-white' }}">Khách hàng</a>
        <a href="{{ route('admin.inventory.index') }}" class="block px-4 py-2 text-sm rounded transition-all {{ request()->routeIs('admin.inventory.*') ? 'text-white font-semibold' : 'text-white/60 hover:text-white' }}">Kho hàng</a>
        <a href="{{ route('admin.analytics.index') }}" class="block px-4 py-2 text-sm rounded transition-all {{ request()->routeIs('admin.analytics.*') ? 'text-white font-semibold' : 'text-white/60 hover:text-white' }}">Báo cáo</a>
    </div>
</div>

<!-- Job Portal Module -->
<div>
    <button @click="activeMenu = (activeMenu === 'jobs' ? '' : 'jobs')" 
            class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition-all {{ request()->is('admin/jobs/*') ? 'bg-white/20 backdrop-blur-sm text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
        <div class="flex items-center">
            <i class="fas fa-briefcase w-5"></i>
            <span class="ml-3 font-medium">Job Portal</span>
        </div>
        <i :class="activeMenu === 'jobs' ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs"></i>
    </button>
    <div x-show="activeMenu === 'jobs'" x-cloak x-collapse class="ml-8 mt-2 space-y-1">
        <a href="{{ route('admin.jobs.postings') }}" class="block px-4 py-2 text-sm rounded transition-all {{ request()->routeIs('admin.jobs.postings') ? 'text-white font-semibold' : 'text-white/60 hover:text-white' }}">Tin tuyển dụng</a>
        <a href="{{ route('admin.jobs.applications') }}" class="block px-4 py-2 text-sm rounded transition-all {{ request()->routeIs('admin.jobs.applications') ? 'text-white font-semibold' : 'text-white/60 hover:text-white' }}">Ứng viên</a>
        <a href="{{ route('admin.jobs.employers') }}" class="block px-4 py-2 text-sm rounded transition-all {{ request()->routeIs('admin.jobs.employers') ? 'text-white font-semibold' : 'text-white/60 hover:text-white' }}">Nhà tuyển dụng</a>
        <a href="{{ route('admin.jobs.workflow') }}" class="block px-4 py-2 text-sm rounded transition-all {{ request()->routeIs('admin.jobs.workflow') ? 'text-white font-semibold' : 'text-white/60 hover:text-white' }}">Quy trình</a>
    </div>
</div>

<!-- User Management -->
<div>
    <button @click="activeMenu = (activeMenu === 'users' ? '' : 'users')" 
            class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition-all {{ request()->is('admin/users*') ? 'bg-white/20 backdrop-blur-sm text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
        <div class="flex items-center">
            <i class="fas fa-users w-5"></i>
            <span class="ml-3 font-medium">Users</span>
        </div>
        <i :class="activeMenu === 'users' ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs"></i>
    </button>
    <div x-show="activeMenu === 'users'" x-cloak x-collapse class="ml-8 mt-2 space-y-1">
        <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 text-sm rounded transition-all {{ request()->routeIs('admin.users.index') ? 'text-white font-semibold' : 'text-white/60 hover:text-white' }}">Tài khoản</a>
        <a href="{{ route('admin.users.roles') }}" class="block px-4 py-2 text-sm rounded transition-all {{ request()->routeIs('admin.users.roles') ? 'text-white font-semibold' : 'text-white/60 hover:text-white' }}">Phân quyền</a>
        <a href="{{ route('admin.users.logs') }}" class="block px-4 py-2 text-sm rounded transition-all {{ request()->routeIs('admin.users.logs') ? 'text-white font-semibold' : 'text-white/60 hover:text-white' }}">Nhật ký</a>
    </div>
</div>

<!-- Settings -->
<a href="{{ route('admin.settings') }}" 
   class="flex items-center px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.settings') ? 'bg-white/20 backdrop-blur-sm text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}"
   data-menu="settings">
    <i class="fas fa-cog w-5"></i>
    <span class="ml-3 font-medium">Cài đặt</span>
</a>
