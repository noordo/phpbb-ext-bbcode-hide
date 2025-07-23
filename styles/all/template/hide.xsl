<xsl:choose>
  <!-- guests-inline (ordre indifférent) -->
  <xsl:when test="@hide='guests-inline' or @hide='inline-guests'">
    <xsl:if test="$S_USER_LOGGED_IN=0 or $S_IS_BOT=1">
      <div class="hidden-content error">{L_HIDDEN_CONTENT_EXPLAIN}</div>
    </xsl:if>
    <xsl:if test="not($S_USER_LOGGED_IN=0 or $S_IS_BOT=1)">
      <span class="hidden-content inline">{TEXT}</span>
    </xsl:if>
  </xsl:when>
  <!-- guests seul -->
  <xsl:when test="@hide='guests'">
    <xsl:if test="$S_USER_LOGGED_IN=0 or $S_IS_BOT=1">
      <div class="hidden-content error">{L_HIDDEN_CONTENT_EXPLAIN}</div>
    </xsl:if>
    <xsl:if test="not($S_USER_LOGGED_IN=0 or $S_IS_BOT=1)">
      <section class="hidden-content">
        <header><span>{L_HIDDEN_CONTENT_VISIBLE_GUESTS}</span></header>
        {TEXT}
      </section>
    </xsl:if>
  </xsl:when>
  <!-- inline seul -->
  <xsl:when test="@hide='inline'">
    <xsl:if test="$S_USER_LOGGED_IN=1 and not($S_IS_BOT) and ($S_HAS_POSTED=1 or $S_IS_ADMIN=1)">
      <span class="hidden-content inline">{TEXT}</span>
    </xsl:if>
    <xsl:if test="not($S_USER_LOGGED_IN=1 and not($S_IS_BOT) and ($S_HAS_POSTED=1 or $S_IS_ADMIN=1))">
      <span class="hidden-content">{L_HIDDEN_CONTENT_EXPLAIN}</span>
    </xsl:if>
  </xsl:when>
  <!-- par défaut -->
  <xsl:otherwise>
    <xsl:if test="$S_USER_LOGGED_IN=1 and not($S_IS_BOT) and ($S_HAS_POSTED=1 or $S_IS_ADMIN=1)">
      <section class="hidden-content">
        <header><span>{L_HIDDEN_CONTENT_VISIBLE_POSTERS}</span></header>
        {TEXT}
      </section>
    </xsl:if>
    <xsl:if test="not($S_USER_LOGGED_IN=1 and not($S_IS_BOT) and ($S_HAS_POSTED=1 or $S_IS_ADMIN=1))">
      <div class="hidden-content">{L_HIDDEN_CONTENT_EXPLAIN}</div>
    </xsl:if>
  </xsl:otherwise>
</xsl:choose>
