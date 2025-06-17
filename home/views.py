# from django.http import HttpResponse

from django.shortcuts import render

# HTTP Request <-> HTTP Response
# MVT (MVC)

# Create your views here.

def home(request):
    return render(
        request,
        'global/base.html'
        )