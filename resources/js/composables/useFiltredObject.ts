export const removeProperties = (obj: any, properties: string[]) => {
  for (const prop of properties) {
    if (obj.hasOwnProperty(prop)) {
      delete obj[prop];
    }
  }

  for (const key in obj) {
    if (typeof obj[key] === "object" && obj[key] !== null) {
      removeProperties(obj[key], properties);
    }
  }
  return obj
}