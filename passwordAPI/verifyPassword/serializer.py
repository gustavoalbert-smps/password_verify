from rest_framework import serializers
from verifyPassword.models import Verify

class VerifySerializer(serializers.ModelSerializer):
    class Meta:
        model = Verify
        fields = '__all__'