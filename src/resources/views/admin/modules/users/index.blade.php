@extends('layouts.admin')

@section('title', 'Quản lý người dùng')

@push('styles')
<style>
    [x-cloak] { display: none !important; }
    .modal-backdrop {
        backdrop-filter: blur(4px);
    }
</style>
@endpush

@section('content')
<div x-data="userManagementData()">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Tổng người dùng</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1" x-text="totalUsers"></p>
                    <p class="text-xs text-green-600 dark:text-green-400 mt-2">
                        <i class="fas fa-arrow-up"></i> +12% so với tháng trước
                    </p>
                </div>
                <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-primary-600 dark:text-primary-400"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Đang hoạt động</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">8</p>
                    <p class="text-xs text-green-600 dark:text-green-400 mt-2">
                        <i class="fas fa-arrow-up"></i> +5% so với tháng trước
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 dark:text-green-400"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Chờ xác nhận</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">2</p>
                    <p class="text-xs text-yellow-600 dark:text-yellow-400 mt-2">
                        <i class="fas fa-minus"></i> Không thay đổi
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-blue-600 dark:text-blue-400"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Bị khóa</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">1</p>
                    <p class="text-xs text-red-600 dark:text-red-400 mt-2">
                        <i class="fas fa-arrow-down"></i> -20% so với tháng trước
                    </p>
                </div>
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-ban text-red-600 dark:text-red-400"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- User List Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        
        <!-- Table Header -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                <div class="flex items-center space-x-4">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Danh sách người dùng</h2>
                </div>
                <div class="flex items-center space-x-3">
                    <button class="px-4 py-2 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium transition-colors">
                        <i class="fas fa-filter mr-2"></i>Lọc
                    </button>
                    <button class="px-4 py-2 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium transition-colors">
                        <i class="fas fa-download mr-2"></i>Xuất Excel
                    </button>
                    <button @click="showAddModal = true"
                            class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-medium transition-colors">
                        <i class="fas fa-plus mr-2"></i>Thêm người dùng
                    </button>
                </div>
            </div>

            <!-- Search and Bulk Actions -->
            <div class="mt-4 flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0">
                <div class="flex items-center space-x-3">
                    <button @click="deleteMultiple()" 
                            x-show="selectedUsers.length > 0"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition-colors">
                        <i class="fas fa-trash mr-2"></i>Xóa (<span x-text="selectedUsers.length"></span>)
                    </button>
                </div>
                <div class="relative">
                    <input type="text" 
                           x-model="searchQuery"
                           placeholder="Tìm kiếm theo tên, email hoặc username..." 
                           class="w-full md:w-80 pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-sm dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            <input type="checkbox" 
                                   @change="selectAll($event)"
                                   class="rounded border-gray-300 dark:border-gray-600 text-primary-600 focus:ring-primary-500">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Người dùng
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Vai trò
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Trạng thái
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Ngày tham gia
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Hành động
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <template x-for="user in filteredUsers.slice((currentPage-1)*perPage, currentPage*perPage)" :key="user.id">
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" 
                                       :value="user.id"
                                       x-model="selectedUsers"
                                       class="rounded border-gray-300 dark:border-gray-600 text-primary-600 focus:ring-primary-500">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img :src="user.avatar" :alt="user.name" class="w-10 h-10 rounded-full">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white" x-text="user.name"></div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400" x-text="user.email"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full"
                                      :class="{
                                        'bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-400': user.role === 'Admin',
                                        'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400': user.role === 'Moderator',
                                        'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-400': user.role === 'User'
                                      }">
                                    <i class="fas mr-1.5"
                                       :class="{
                                         'fa-crown': user.role === 'Admin',
                                         'fa-shield-alt': user.role === 'Moderator',
                                         'fa-user': user.role === 'User'
                                       }"></i>
                                    <span x-text="user.role"></span>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full"
                                      :class="{
                                        'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400': user.status === 'active',
                                        'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400': user.status === 'pending',
                                        'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400': user.status === 'blocked'
                                      }">
                                    <i class="fas mr-1.5"
                                       :class="{
                                         'fa-check-circle': user.status === 'active',
                                         'fa-clock': user.status === 'pending',
                                         'fa-ban': user.status === 'blocked'
                                       }"></i>
                                    <span x-text="user.status === 'active' ? 'Đang hoạt động' : (user.status === 'pending' ? 'Chờ xác nhận' : 'Bị khóa')"></span>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400" x-text="user.joinDate"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button @click="viewUser(user)" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300 mr-3">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button @click="editUser(user)" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-3">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button @click="deleteUser(user.id)" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                Hiển thị <span x-text="(currentPage - 1) * perPage + 1"></span> - 
                <span x-text="Math.min(currentPage * perPage, totalUsers)"></span> 
                trong tổng số <span x-text="totalUsers"></span> người dùng
            </div>
            <div class="flex space-x-2">
                <button @click="currentPage > 1 && currentPage--"
                        :disabled="currentPage === 1"
                        class="px-3 py-1 rounded border border-gray-300 dark:border-gray-600 text-sm disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 dark:hover:bg-gray-700 dark:text-gray-300">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <template x-for="page in totalPages" :key="page">
                    <button @click="currentPage = page"
                            :class="currentPage === page ? 'bg-primary-600 text-white' : 'border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 dark:text-gray-300'"
                            class="px-3 py-1 rounded text-sm"
                            x-text="page">
                    </button>
                </template>
                <button @click="currentPage < totalPages && currentPage++"
                        :disabled="currentPage === totalPages"
                        class="px-3 py-1 rounded border border-gray-300 dark:border-gray-600 text-sm disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 dark:hover:bg-gray-700 dark:text-gray-300">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- View User Modal -->
    <div x-show="showViewModal" x-cloak
         class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop z-50 flex items-center justify-center p-4">
        <div @click.away="showViewModal = false"
             class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            
            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Chi tiết người dùng</h3>
                <button @click="showViewModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="p-6" x-show="selectedUser">
                <div class="flex flex-col items-center mb-6">
                    <img :src="selectedUser?.avatar" :alt="selectedUser?.name" 
                         class="w-24 h-24 rounded-full border-4 border-gray-200 dark:border-gray-600 mb-4">
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white" x-text="selectedUser?.name"></h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400" x-text="'@' + selectedUser?.username"></p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                        <p class="text-sm text-gray-600 dark:text-gray-400" x-text="selectedUser?.email"></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Vai trò</label>
                        <span class="px-2 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full"
                              :class="{
                                'bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-400': selectedUser?.role === 'Admin',
                                'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400': selectedUser?.role === 'Moderator',
                                'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-400': selectedUser?.role === 'User'
                              }">
                            <i class="fas mr-1.5"
                               :class="{
                                 'fa-crown': selectedUser?.role === 'Admin',
                                 'fa-shield-alt': selectedUser?.role === 'Moderator',
                                 'fa-user': selectedUser?.role === 'User'
                               }"></i>
                            <span x-text="selectedUser?.role"></span>
                        </span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Trạng thái</label>
                        <span class="px-2 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full"
                              :class="{
                                'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400': selectedUser?.status === 'active',
                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400': selectedUser?.status === 'pending',
                                'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400': selectedUser?.status === 'blocked'
                              }">
                            <i class="fas mr-1.5"
                               :class="{
                                 'fa-check-circle': selectedUser?.status === 'active',
                                 'fa-clock': selectedUser?.status === 'pending',
                                 'fa-ban': selectedUser?.status === 'blocked'
                               }"></i>
                            <span x-text="selectedUser?.status === 'active' ? 'Đang hoạt động' : (selectedUser?.status === 'pending' ? 'Chờ xác nhận' : 'Bị khóa')"></span>
                        </span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ngày tham gia</label>
                        <p class="text-sm text-gray-600 dark:text-gray-400" x-text="selectedUser?.joinDate"></p>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Thông tin bổ sung</h5>
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">156</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Bài viết</p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">892</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Người theo dõi</p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">345</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Đang theo dõi</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-4 p-6 border-t border-gray-200 dark:border-gray-700">
                <button @click="showViewModal = false"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                    Đóng
                </button>
                <button @click="showViewModal = false; editUser(selectedUser)"
                        class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-medium">
                    <i class="fas fa-edit mr-2"></i>Chỉnh sửa
                </button>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div x-show="showEditModal" x-cloak
         class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop z-50 flex items-center justify-center p-4">
        <div @click.away="showEditModal = false"
             class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            
            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Chỉnh sửa người dùng</h3>
                <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="p-6" x-show="editingUser">
                <form @submit.prevent="updateUser()" class="space-y-6">
                    <div class="flex items-center space-x-6">
                        <img :src="editingUser?.avatar" class="w-20 h-20 rounded-full border-2 border-gray-200 dark:border-gray-600">
                        <div>
                            <input type="file" id="edit-avatar-upload" accept="image/jpeg,image/png,image/gif" class="hidden" 
                                   @change="handleAvatarUpload($event, 'edit')">
                            <button type="button" 
                                    @click="$el.parentElement.querySelector('#edit-avatar-upload').click()"
                                    class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-medium">
                                <i class="fas fa-upload mr-2"></i>Tải ảnh lên
                            </button>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">JPG, PNG hoặc GIF (tối đa 2MB)</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Họ tên</label>
                        <input type="text" x-model="editingUser.name" 
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Username</label>
                        <input type="text" x-model="editingUser.username" 
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                        <input type="email" x-model="editingUser.email" 
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Vai trò</label>
                        <select x-model="editingUser.role" 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                            <option value="Admin">Admin</option>
                            <option value="Moderator">Moderator</option>
                            <option value="User">User</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Trạng thái</label>
                        <div class="space-y-3">
                            <label class="flex items-center cursor-pointer group">
                                <input type="radio" name="edit-status" value="active" x-model="editingUser.status"
                                       class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>Đang hoạt động
                                </span>
                            </label>
                            <label class="flex items-center cursor-pointer group">
                                <input type="radio" name="edit-status" value="pending" x-model="editingUser.status"
                                       class="w-4 h-4 text-yellow-600 bg-gray-100 border-gray-300 focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white">
                                    <i class="fas fa-clock text-yellow-500 mr-2"></i>Chờ xác nhận
                                </span>
                            </label>
                            <label class="flex items-center cursor-pointer group">
                                <input type="radio" name="edit-status" value="blocked" x-model="editingUser.status"
                                       class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white">
                                    <i class="fas fa-ban text-red-500 mr-2"></i>Bị khóa
                                </span>
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button type="button" @click="showEditModal = false"
                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                            Hủy
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-medium">
                            <i class="fas fa-save mr-2"></i>Lưu thay đổi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div x-show="showAddModal" x-cloak
         @close-modal.window="showAddModal = false; resetAddModal()"
         class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop z-50 flex items-center justify-center p-4">
        <div @click.away="showAddModal = false; resetAddModal()"
             class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            
            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Thêm người dùng mới</h3>
                <button @click="showAddModal = false; resetAddModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="p-6">
                <form class="space-y-6">
                    <div class="flex items-center space-x-6">
                        <img :src="newUserAvatar || 'https://ui-avatars.com/api/?name=New+User&background=0ea5e9&color=fff'" 
                             class="w-20 h-20 rounded-full border-2 border-gray-200 dark:border-gray-600 object-cover">
                        <div>
                            <input type="file" id="add-avatar-upload" accept="image/jpeg,image/png,image/gif" class="hidden"
                                   @change="handleAvatarUpload($event, 'add')">
                            <button type="button" 
                                    @click="$el.parentElement.querySelector('#add-avatar-upload').click()"
                                    class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-medium">
                                <i class="fas fa-upload mr-2"></i>Tải ảnh lên
                            </button>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">JPG, PNG hoặc GIF (tối đa 2MB)</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Họ tên *</label>
                        <input type="text" required
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Username *</label>
                        <input type="text" required
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email *</label>
                        <input type="email" required
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mật khẩu *</label>
                        <input type="password" required
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Vai trò</label>
                        <select class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                            <option value="User">User</option>
                            <option value="Moderator">Moderator</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Trạng thái</label>
                        <div class="space-y-3">
                            <label class="flex items-center cursor-pointer group">
                                <input type="radio" name="add-status" value="active" checked
                                       class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>Đang hoạt động
                                </span>
                            </label>
                            <label class="flex items-center cursor-pointer group">
                                <input type="radio" name="add-status" value="pending"
                                       class="w-4 h-4 text-yellow-600 bg-gray-100 border-gray-300 focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white">
                                    <i class="fas fa-clock text-yellow-500 mr-2"></i>Chờ xác nhận
                                </span>
                            </label>
                        </div>
                    </div>
                </form>
            </div>

            <div class="flex items-center justify-end space-x-4 p-6 border-t border-gray-200 dark:border-gray-700">
                <button @click="showAddModal = false"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                    Hủy
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-medium">
                    <i class="fas fa-plus mr-2"></i>Thêm người dùng
                </button>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function userManagementData() {
        return {
            showAddModal: false,
            showViewModal: false,
            showEditModal: false,
            searchQuery: '',
            selectedUsers: [],
            currentPage: 1,
            perPage: 10,
            selectedUser: null,
            editingUser: null,
            newUserAvatar: null,
            
            users: [
                { id: 1, name: 'Nguyễn Văn An', username: 'nguyenvanan', email: 'an.nguyen@example.com', role: 'Admin', status: 'active', joinDate: '15/01/2024', avatar: 'https://ui-avatars.com/api/?name=Nguyen+Van+An&background=0ea5e9&color=fff' },
                { id: 2, name: 'Trần Thị Bình', username: 'tranthibinh', email: 'binh.tran@example.com', role: 'Moderator', status: 'active', joinDate: '20/01/2024', avatar: 'https://ui-avatars.com/api/?name=Tran+Thi+Binh&background=10b981&color=fff' },
                { id: 3, name: 'Lê Minh Cường', username: 'leminhcuong', email: 'cuong.le@example.com', role: 'User', status: 'active', joinDate: '22/01/2024', avatar: 'https://ui-avatars.com/api/?name=Le+Minh+Cuong&background=f59e0b&color=fff' },
                { id: 4, name: 'Phạm Thị Dung', username: 'phamthidung', email: 'dung.pham@example.com', role: 'User', status: 'pending', joinDate: '25/01/2024', avatar: 'https://ui-avatars.com/api/?name=Pham+Thi+Dung&background=8b5cf6&color=fff' },
                { id: 5, name: 'Hoàng Văn Em', username: 'hoangvanem', email: 'em.hoang@example.com', role: 'User', status: 'blocked', joinDate: '28/01/2024', avatar: 'https://ui-avatars.com/api/?name=Hoang+Van+Em&background=ef4444&color=fff' },
                { id: 6, name: 'Vũ Thị Phương', username: 'vuthiphuong', email: 'phuong.vu@example.com', role: 'Moderator', status: 'active', joinDate: '01/02/2024', avatar: 'https://ui-avatars.com/api/?name=Vu+Thi+Phuong&background=06b6d4&color=fff' },
                { id: 7, name: 'Đặng Minh Tuấn', username: 'dangminhtuan', email: 'tuan.dang@example.com', role: 'User', status: 'active', joinDate: '03/02/2024', avatar: 'https://ui-avatars.com/api/?name=Dang+Minh+Tuan&background=6366f1&color=fff' },
                { id: 8, name: 'Mai Thị Hoa', username: 'maithihoa', email: 'hoa.mai@example.com', role: 'User', status: 'active', joinDate: '05/02/2024', avatar: 'https://ui-avatars.com/api/?name=Mai+Thi+Hoa&background=ec4899&color=fff' },
                { id: 9, name: 'Bùi Văn Hải', username: 'buivanhai', email: 'hai.bui@example.com', role: 'User', status: 'pending', joinDate: '08/02/2024', avatar: 'https://ui-avatars.com/api/?name=Bui+Van+Hai&background=14b8a6&color=fff' },
                { id: 10, name: 'Ngô Thị Lan', username: 'ngothilan', email: 'lan.ngo@example.com', role: 'User', status: 'active', joinDate: '10/02/2024', avatar: 'https://ui-avatars.com/api/?name=Ngo+Thi+Lan&background=f97316&color=fff' },
            ],

            get filteredUsers() {
                if (!this.searchQuery) return this.users;
                
                const query = this.searchQuery.toLowerCase();
                return this.users.filter(user => 
                    user.name.toLowerCase().includes(query) ||
                    user.email.toLowerCase().includes(query) ||
                    user.username.toLowerCase().includes(query)
                );
            },

            get totalUsers() {
                return this.filteredUsers.length;
            },

            get totalPages() {
                return Math.ceil(this.totalUsers / this.perPage);
            },

            selectAll(event) {
                if (event.target.checked) {
                    this.selectedUsers = this.filteredUsers.map(u => u.id);
                } else {
                    this.selectedUsers = [];
                }
            },

            viewUser(user) {
                this.selectedUser = user;
                this.showViewModal = true;
            },

            editUser(user) {
                this.editingUser = { ...user };
                this.showEditModal = true;
            },

            updateUser() {
                const index = this.users.findIndex(u => u.id === this.editingUser.id);
                if (index !== -1) {
                    this.users[index] = { ...this.editingUser };
                    this.showEditModal = false;
                    
                    Swal.fire({
                        title: 'Thành công!',
                        text: 'Cập nhật người dùng thành công',
                        icon: 'success',
                        confirmButtonColor: '#0ea5e9'
                    });
                }
            },

            deleteUser(userId) {
                Swal.fire({
                    title: 'Xác nhận xóa?',
                    html: `Bạn có chắc chắn muốn xóa người dùng này?<br><span style="color: #6b7280; font-size: 0.875rem;">Hành động này không thể hoàn tác!</span>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Xóa',
                    cancelButtonText: 'Hủy',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.users = this.users.filter(u => u.id !== userId);
                        Swal.fire({
                            title: 'Đã xóa!',
                            text: 'Người dùng đã được xóa thành công',
                            icon: 'success',
                            confirmButtonColor: '#0ea5e9'
                        });
                    }
                });
            },

            deleteMultiple() {
                if (this.selectedUsers.length === 0) return;
                
                Swal.fire({
                    title: 'Xác nhận xóa?',
                    html: `Bạn có chắc chắn muốn xóa <strong>${this.selectedUsers.length}</strong> người dùng đã chọn?<br><span style="color: #6b7280; font-size: 0.875rem;">Hành động này không thể hoàn tác!</span>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Xóa',
                    cancelButtonText: 'Hủy',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.users = this.users.filter(u => !this.selectedUsers.includes(u.id));
                        this.selectedUsers = [];
                        Swal.fire({
                            title: 'Đã xóa!',
                            text: 'Các người dùng đã được xóa thành công',
                            icon: 'success',
                            confirmButtonColor: '#0ea5e9'
                        });
                    }
                });
            },

            handleAvatarUpload(event, type) {
                const file = event.target.files[0];
                
                if (!file) return;
                
                // Kiểm tra định dạng file
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    Swal.fire({
                        title: 'Lỗi!',
                        text: 'Vui lòng chọn file ảnh định dạng JPG, PNG hoặc GIF',
                        icon: 'error',
                        confirmButtonColor: '#ef4444'
                    });
                    event.target.value = '';
                    return;
                }
                
                // Kiểm tra kích thước file (2MB = 2 * 1024 * 1024 bytes)
                if (file.size > 2 * 1024 * 1024) {
                    Swal.fire({
                        title: 'Lỗi!',
                        text: 'Kích thước ảnh không được vượt quá 2MB',
                        icon: 'error',
                        confirmButtonColor: '#ef4444'
                    });
                    event.target.value = '';
                    return;
                }
                
                // Đọc file và tạo preview
                const reader = new FileReader();
                reader.onload = (e) => {
                    const imageUrl = e.target.result;
                    
                    if (type === 'edit' && this.editingUser) {
                        // Cập nhật preview cho modal edit
                        this.editingUser.avatar = imageUrl;
                    } else if (type === 'add') {
                        // Cập nhật preview cho modal add
                        this.newUserAvatar = imageUrl;
                    }
                    
                    Swal.fire({
                        title: 'Thành công!',
                        text: 'Ảnh đã được tải lên thành công',
                        icon: 'success',
                        confirmButtonColor: '#0ea5e9',
                        timer: 1500,
                        showConfirmButton: false
                    });
                };
                reader.readAsDataURL(file);
            },

            // Reset avatar khi đóng modal add
            resetAddModal() {
                this.newUserAvatar = null;
                const input = document.getElementById('add-avatar-upload');
                if (input) input.value = '';
            }
        }
    }
</script>
@endpush
