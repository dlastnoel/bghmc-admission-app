export function getProperty(item, property) {
  return property.split('.').reduce(function(p,prop) { return p[prop] }, item)
}