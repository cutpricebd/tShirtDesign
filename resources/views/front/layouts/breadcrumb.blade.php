<nav aria-label="Breadcrumb" class="mb-4">
    <ol role="list" class="container flex pt-2" itemscope itemtype="https://schema.org/BreadcrumbList">
      <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <div class="flex items-center">
          <a href="{{route('homepage')}}" class="mr-2 text-sm font-medium text-font-color-dark flex" itemprop="item">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>

            <span class="ml-1" itemprop="name">Home</span>
          </a>

          <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="w-4 h-5 text-font-color-dark">
            <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
          </svg>

          <meta itemprop="position" content="1" />
        </div>
      </li>

      <li class="text-sm" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <a href="{{ url('') }}/{{$url}}" itemprop="item"><span aria-current="page" class="font-medium text-font-color-dark" itemprop="name"> {{$title}} </span></a>


        <meta itemprop="position" content="2" />
      </li>
    </ol>
</nav>
