from django.contrib.postgres.fields import ArrayField
from django.db import models

class Verify(models.Model):
    password = models.CharField(max_length=200)
    rules = ArrayField(ArrayField(models.JSONField(blank=True), blank=True))