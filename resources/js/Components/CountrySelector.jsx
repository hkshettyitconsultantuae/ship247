import React, { useState, useMemo } from 'react'
import Select from 'react-select'
import countryList from 'react-select-country-list'

function CountrySelector({defaultValue, onChange}) {
    const [value, setValue] = useState(defaultValue)
  const options = useMemo(() => countryList().getData(), []);

  const changeHandler = value => {
    setValue(value);
    onChange(value)
  }

  return <Select options={options} value={value} onChange={changeHandler} />
}

export default CountrySelector