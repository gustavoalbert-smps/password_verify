from rest_framework import viewsets
from verifyPassword.serializer import VerifySerializer
from verifyPassword.models import Verify
from django.http import JsonResponse

class VerifyViewSet(viewsets.ModelViewSet):
    queryset = Verify.objects.all()
    serializer_class = VerifySerializer