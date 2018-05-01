<% if $EnabledLinks %>
  <div class="links">
    <ul class="$ListClass">
      <% loop $EnabledLinks %>
        <li class="$LinkingMode">
          <% if $Up.ListIcon %><% include Icon Name=$Up.ListIcon, ListItem=1 %><% end_if %>
          {$render}
        </li>
      <% end_loop %>
    </ul>
  </div>
<% end_if %>
