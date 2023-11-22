import * as React from "react";

const TabSelector = ({
  isActive,
  children,
  onClick,
}) => (<button onClick={onClick}> {children} </button>
);

export default TabSelector;
