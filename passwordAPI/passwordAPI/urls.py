from django.contrib import admin
from django.urls import path, include
from verifyPassword.views import VerifyViewSet
from rest_framework import routers

router = routers.DefaultRouter()
router.register('verify', VerifyViewSet, basename='verify')

urlpatterns = [
    path('admin/', admin.site.urls),
    path('', include(router.urls)),
]
