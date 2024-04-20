export function isRouteActive(routeLink) {
  return route().current(routeLink)
}