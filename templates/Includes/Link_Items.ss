<% if $Links %>
  <div class="links">
    <% loop $Links %>
      <article class="link">
        <h4>$Title</h4>
        <section class="url">
          <a href="$LinkURL.URL"<% if $OpenInNewTab %> target="_blank"<% end_if %>>$LinkURL.URL</a>
        </section>
      </article>
    <% end_loop %>
  </div>
<% end_if %>