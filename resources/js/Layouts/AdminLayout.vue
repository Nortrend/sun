<template>
  <div class="admin-layout">
    <header class="header">
      <h1 class="title">Admin Panel</h1>
    </header>
    <nav class="sidebar">
      <ul>
        <li>
          <Link :href="route('admin.posts.index')">Posts</Link>
        </li>
        <li>
          <Link :href="route('admin.articles.index')">Articles</Link>
        </li>
        <li>
          <Link :href="route('admin.comments.index')">Comments</Link>
        </li>
          <li>
          <Link :href="route('admin.users.index')">Users</Link>
        </li>
          <li>
           <Link :href="route('admin.categories.index')">Categories</Link>
        </li>
          <li>
              <Link :href="route('admin.profiles.index')">Profiles</Link>
          </li>
      </ul>
    </nav>
    <main class="content">
      <slot />
    </main>
  </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";

export default {
  name: 'AdminLayout',
  components: {
    Link,
  }
}
</script>

<style scoped>
.admin-layout {
  display: grid;
  grid-template-columns: 240px 1fr;
  grid-template-rows: 60px 1fr;
  grid-template-areas:
    "header header"
    "sidebar content";
  height: 100vh;
  background-color: #121212;
  color: #e0e0e0;
  font-family: 'Courier New', Courier, monospace;
}

.header {
  grid-area: header;
  display: flex;
  align-items: center;
  padding: 0 1.5rem;
  background-color: #1f1f1f;
  border-bottom: 1px solid #333;
}

.title {
  font-size: 1.8rem;
  font-weight: bold;
  color: #f4f4f4;
  letter-spacing: 1px;
}

.sidebar {
  grid-area: sidebar;
  background-color: #1a1a1a;
  border-right: 1px solid #333;
  padding: 2rem 1rem;
}

.sidebar ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.sidebar li {
  margin-bottom: 1.5rem;
}

.sidebar a,
.sidebar :is(a, .link) {
  text-decoration: none;
  color: #ccc;
  font-size: 1rem;
  transition: color 0.3s;
  display: inline-block;
}

.sidebar a:hover,
.sidebar :is(a, .link):hover {
  color: #fff;
}

.content {
  grid-area: content;
  padding: 2rem;
  background-color: #181818;
  overflow-y: auto;
  box-shadow: inset 0 0 20px rgba(0,0,0,0.4);
}
</style>
