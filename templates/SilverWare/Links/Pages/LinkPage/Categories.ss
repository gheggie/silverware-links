<% if $VisibleCategories %>
  <div class="categories">
    <% loop $VisibleCategories %>
      <section $AttributesHTML>
        <header>
          <{$Up.HeadingTag}>$Title</{$Up.HeadingTag}>
        </header>
        <% include SilverWare\Links\Pages\LinkCategory\Links %>
      </section>
    <% end_loop %>
  </div>
<% else %>
  <% include Alert Type='warning', Text=$NoDataMessage %>
<% end_if %>
