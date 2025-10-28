import { registerBlockType } from "@wordpress/blocks";
import Edit from "./edit";

registerBlockType("plk/spacer", {
	edit: Edit,
	save: () => null,
});
