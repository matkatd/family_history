async function getData(file) {
  const response = await fetch(file);

  const data = await response.json();
  return data;
}

async function parse() {
  const data = await getData("./mytree.json");
  const peopleSQL = personSQL(data.people);
  const para = document.querySelector("#test");
  //output(peopleSQL, para);
  output(familySQL(data.families), para);
}

function personSQL(obj) {
  return obj
    .map(
      (
        item
      ) => `INSERT INTO people (first_name, last_name, birth_date, birth_place, death_date, death_place, gender, fams, famc, person_id)
                        VALUES ('${item.names[0].givn}','${
        item.names[0].surn
      }',"${getEventDetails(
        item.eventsFacts,
        "BIRT",
        "date"
      )}","${getEventDetails(
        item.eventsFacts,
        "BIRT",
        "place"
      )}","${getEventDetails(
        item.eventsFacts,
        "DEAT",
        "date"
      )}","${getEventDetails(
        item.eventsFacts,
        "DEAT",
        "place"
      )}","${getEventDetails(item.eventsFacts, "SEX", "value")}","${
        item.fams ? item.fams[0].ref : ""
      }","${item.famc ? item.famc[0].ref : ""}", "${item.id}");
    `
    )
    .join("<br>");
}

function familySQL(obj) {
  return obj
    .map(
      (item) => `
        INSERT INTO families (family_id, husband_id, wife_id, children_ids)
        VALUES ("${item.id}", "${
        item.husbandRefs ? item.husbandRefs[0].ref : ""
      }", 
        "${item.wifeRefs ? item.wifeRefs[0].ref : ""}", 
        '${item.childRefs ? JSON.stringify(item.childRefs) : "{}"}');

    
    `
      // SELECT * FROM families
      // WHERE id IN families.children_ids
    )
    .join("<br>");
}

function output(data, element) {
  element.innerHTML += data;
}

function getEventDetails(obj, key, field) {
  const found = obj.find((item) => item.tag == key);
  if (!found) {
    return "";
  } else {
    return found[field] ? found[field] : "";
  }
}

parse();
