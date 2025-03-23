self.addEventListener('install', (event) => {
    console.log('⚡ Service Worker تم تثبيته');
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    console.log('✅ Service Worker مفعل');
    self.clients.claim();
});

// تسجيل حدث Background Sync
self.addEventListener('sync', (event) => {
    if (event.tag === 'update-location') {
        console.log('🔄 Background Sync: محاولة تحديث الموقع...');
        event.waitUntil(updateLocation());
    }
});

async function updateLocation() {
    try {
        const clients = await self.clients.matchAll({ includeUncontrolled: true });

        if (clients.length === 0) {
            console.warn('⚠️ لا يوجد عملاء نشطين للحصول على الموقع.');
            return;
        }

        // إرسال طلب للصفحة المفتوحة للحصول على الموقع
        clients[0].postMessage({ action: 'getLocation' });

    } catch (error) {
        console.error('❌ خطأ في تحديث الموقع في الخلفية:', error);
    }
}
