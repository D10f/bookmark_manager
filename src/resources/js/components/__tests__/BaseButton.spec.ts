import { test, expect } from "vitest";
import { mount, shallowMount } from "@vue/test-utils";
import BaseButton from "../BaseButton.vue";

test("", () => {
    const wrapper = shallowMount(BaseButton);
    const button = wrapper.find("button");
    expect(button).toBeTruthy();
});
