<% if $Categories %>
  <div class="categories" data-toggle="$ToggleCategories.NiceAsBoolean" data-start="$CategoriesStart">
    <% loop $Categories %>
      <article class="category">
        <header>
          <h3><i class="icon fa fa-fw"></i> <span>$Title</span></h3>
        </header>
        <% include Link_Items %>
      </article>
    <% end_loop %>
  </div>
<% end_if %>